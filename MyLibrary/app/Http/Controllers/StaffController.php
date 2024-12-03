<?php
namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    // Menampilkan semua data staff
    public function dashboardStaff()

    {

        // // $staffs = Auth::user()->staff;
        // $loans = Loan::with('book')->whereIn('status', ['pengajuan pengembalian', 'pengajuan'])->get();
        // $countPendingReturns = $loans->count();
        // return view('dashboard.staff.home', compact( 'loans', 'countPendingReturns'));
    }

    // app/Http/Controllers/StaffController.php

    public function show($id)
    {
        // Ambil data staff berdasarkan ID
        $staff = Staff::with('user')->findOrFail($id);

        // Kirim data staff ke view
        return view('dashboard.staff.show', compact('staff'));
    }


    // Menampilkan form untuk menambah data staff
    public function create()
    {
        return view('dashboard.staff.create');
    }

    // Menyimpan data staff baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'no_telepon' => 'required',
            'gender' => ['required', 'in:Laki Laki,Perempuan'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'staff',
        ]);

        Staff::create([
            'user_id' => $user->id,
            'gender' => $request->gender,
            'no_telepon' => $request->no_telepon,
            'tanggal_bergabung' => now(),
        ]);

        return redirect()->route('staff.index')->with('success', 'Staff berhasil ditambahkan.');
    }

    // Menampilkan form edit data staff
    public function edit(Staff $staff)
    {
        return view('dashboard.staff.edit', compact('staff'));
    }

    // Memperbarui data staff
    public function update(Request $request, Staff $staff)
    {
        $request->validate([
            'no_telepon' => 'required',
            'gender' => 'required',
        ]);

        $staff->update($request->only('no_telepon', 'gender'));

        $staff->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('staff.index')->with('success', 'Staff berhasil diperbarui.');
    }

    // Menghapus data staff
    public function destroy(Staff $staff)
    {
        $staff->user->delete(); // Hapus user terkait
        $staff->delete();

        return redirect()->route('staff.index')->with('success', 'Staff berhasil dihapus.');
    }
}
