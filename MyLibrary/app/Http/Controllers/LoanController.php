<?php

namespace App\Http\Controllers;

use App\Models\Book\Book;
use App\Models\Loan;
use App\Models\Mahasiswa;
use App\Models\Notification;
use App\Models\Review;
use Illuminate\Http\Request;
// use Illuminate\Support\Carbon;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendLoanNotifications;
use PhpParser\Node\Expr\AssignOp\Concat;

class LoanController extends Controller
{

    public function propose($Id)
    {
        $mahasiswa = Auth::user()->mahasiswa;
        $book = Book::findOrFail($Id); // Cari buku berdasarkan ID
        return view('peminjaman.create', compact('mahasiswa', 'book'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'book_id' => 'required|exists:books,id',
            'required_date' => 'required|date',
        ]);

        $book = Book::findOrFail($request->book_id);

        // Cek jika stok buku cukup (stok > 0)
        if ($book->jumlahStock <= 0) {
            return redirect()->back()->with('error', 'Stok buku tidak cukup.');
        }

        // Ambil mahasiswa yang sedang mengajukan peminjaman
        $mahasiswaId = $request->mahasiswa_id;
        $activeLoansCount = Loan::where('mahasiswa_id', $mahasiswaId)
            ->whereIn('status', ['pengajuan', 'dalam pinjaman'])
            ->count();

        // Batasi peminjaman hingga maksimal 5
        $loanLimit = 5;
        if ($activeLoansCount >= $loanLimit) {
            return redirect()->back()->with('limitReached', true);
        }

        // Lanjutkan dengan proses peminjaman jika belum mencapai batas
        Loan::create([
            'mahasiswa_id' => $mahasiswaId,
            'book_id' => $request->book_id,
            'required_date' => $request->required_date,
            'status' => 'pengajuan',
        ]);

        return redirect()->route('loan.listLoan')->with('success', 'Peminjaman berhasil diajukan.');
    }




    public function loanRequestALL()
    {
        $loans = Loan::all();
        return view('dashboard.staff.loans', compact('loans'));
    }
    public function loanReturnAll()
    {
        $loans = Loan::all();
        return view('dashboard.staff.return', compact('loans'));
    }





    public function loanMahasiswaList()
    {
        // Ambil data mahasiswa yang sedang login
        $mahasiswa = Auth::user()->mahasiswa;

        // Ambil semua pinjaman yang terkait dengan mahasiswa tersebut
        $loans = Loan::where('mahasiswa_id', $mahasiswa->id)->get();

        // Kirim data pinjaman ke view
        return view('dashboard.mahasiswa.myshelf', compact('loans'));

        // Kirim notifikasi untuk setiap pinjaman

    }

    public function approveBorrow(Request $request, $id)
    {
        $mahasiswa = Auth::user()->mahasiswa;
        $loan = Loan::findOrFail($id);

        // Validasi input dari request
        $request->validate([
            'staff_id' => 'required|exists:staff,id',
        ]);

        // Pastikan status pinjaman masih pengajuan
        if ($loan->status !== 'pengajuan') {
            return response()->json(['message' => 'Hanya pengajuan yang bisa disetujui.'], 400);
        }

        // Ambil buku yang terkait dengan pinjaman ini
        $book = $loan->book;  // Misal 'book' adalah relasi antara loan dan book

        // Cek jika stok buku cukup (stok > 0)
        if ($book->jumlahStock <= 0) {
            return response()->json(['message' => 'Stok buku tidak cukup.'], 400);
        }

        // Kurangi stok buku sebanyak 1
        $book->decrement('jumlahStock', 1);

        // Update status pinjaman menjadi 'dalam pinjaman' dan data lainnya
        $loan->update([
            'staff_borrow_id' => $request->staff_id,
            'status' => 'dalam pinjaman',
            'borrow_date' => now(),
        ]);
        return redirect()->route('staff.loanRequest');

        // Kembalikan response sukses
        return response()->json(['message' => 'Peminjaman berhasil disetujui.', 'loan' => $loan]);
    }






    public function returnBook(Request $request, $loanId)
    {
        $loan = Loan::findOrFail($loanId);

        if ($loan->status != 'dalam pinjaman') {
            return redirect()->back()->with('error', 'Buku tidak dalam status pinjaman.');
        }

        // Update status pinjaman menjadi 'pengajuan pengembalian' dan set tanggal pengembalian
        $loan->update([
            'return_date' => now(),
            'status' => 'pengajuan pengembalian',
        ]);

        // Jika review dikirimkan, simpan review
        if ($request->has('rating') && $request->has('comment')) {
            // Validasi inputan rating dan ulasan
            $validated = $request->validate([
                'rating' => 'required|integer|min:1|max:5',  // Rating harus antara 1 dan 5
                'comment' => 'nullable|string|max:1000',     // Komentar bersifat opsional
            ]);

            // Cek apakah review sudah ada untuk loan ini
            if ($loan->review) {
                return redirect()->back()->with('error', 'Anda sudah memberikan review untuk buku ini.');
            }

            // Simpan review baru
            $comment = $validated['comment'] ?? '';

            // Simpan review baru
            Review::create([
                'loan_id' => $loan->id,
                'rating' => $validated['rating'],
                'comment' => $comment, // Pastikan comment tidak null jika tidak ada
            ]);

            return redirect()->route('loan.listLoan');
        }

    }




    public function showReturns()
    {
        $loans = Loan::where('status', 'pengajuan pengembalian')->get();
        return view('staff.return', compact('loans'));
    }





    public function approveReturn(Request $request, $id)
    {
        $request->validate([
            'staff_id' => 'required|exists:staff,id',
        ]);

        $loan = Loan::findOrFail($id);

        if ($loan->status !== 'pengajuan pengembalian') {
            return response()->json(['message' => 'Hanya buku dalam pinjaman yang bisa dikembalikan.'], 400);
        }
         // Ambil buku yang terkait dengan pinjaman ini
         $book = $loan->book;  // Misal 'book' adalah relasi antara loan dan book
        $book->increment('jumlahStock', 1);

        $loan->update([
            'staff_return_id' => $request->staff_id,
            'status' => 'dikembalikan',
        ]);
        return redirect()->route('staff.loanRequest');
    }

    public function updateFine(Loan $loan, Request $request)
    {
        // Validasi input, jika diperlukan
        $request->validate([
            'fine' => 'required|numeric|min:0',
        ]);

        // Update nilai denda
        $loan->denda = $request->input('fine');

        // Simpan perubahan ke database
        $loan->save();


    }
    public function extend(Request $request, Loan $loan)
    {
        // Validasi tanggal perpanjangan
        $request->validate([
            'extend_date' => 'required|date|after_or_equal:today',
        ]);

        // Perbarui tanggal pengembalian
        $loan->required_date = $request->input('extend_date');
        $loan->status = 'dalam pinjaman'; // status perpanjangan (sesuaikan dengan kebutuhan)
        $loan->save();

        return redirect()->back()->with('success', 'Masa peminjaman berhasil diperpanjang!');
    }

}

