<?php

namespace App\Http\Controllers;

use App\Models\Book\Book;
use App\Models\Book\SubCategory;
use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'mahasiswa')->with('mahasiswa')->get();

        return view('dashboard.admin.daftarMahasiswa', compact('users'));
    }


    public function create()
    {

        return view('dashboard.mahasiswa.create');
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:'.User::class,
                function ($attribute, $value, $fail) {
                    if (!str_ends_with($value, '@student.unhas.ac.id')) {
                        $fail('Email harus menggunakan domain @student.unhas.ac.id.');
                    }
                },
            ],
            'password' => 'required',
            'tanggal_lahir' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'jenis_kelamin' => 'required|in:L,P',
            'nim' => 'required|string|max:20|unique:mahasiswas,nim',
            'program_studi' => 'required|string|max:255',
            'angkatan' => 'required|integer',
            'telepon' => 'nullable|string|max:15',
        ]);

        // Menyimpan gambar jika ada
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('mahasiswa-image', 'public');
        }

        // Menyimpan data user ke tabel users
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $imagePath, // Menyimpan path gambar
        ]);

        // Menyimpan data mahasiswa ke tabel mahasiswas
        Mahasiswa::create([
            'user_id' => $user->id,
            'nim' => $request->nim,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'program_studi' => $request->program_studi,
            'angkatan' => $request->angkatan,
            'telepon' => $request->telepon,
        ]);


        return redirect(route('dashboard'));
    }

    public function destroy(User $user, int $id)
    {
        // Hapus gambar jika ada
        $user = User::all()->where('id','=',$id)->first();
        // return dd($user);
        if ($user->image) {
            Storage::delete($user->image);
        }
        $user->delete();

        // Redirect ke halaman daftar buku dengan pesan sukses
        return redirect()->back()->with('success', 'Buku berhasil dihapus');
    }
    public function show(Book $book)
    {
        $subCategories = SubCategory::all();
        return view('dashboard.mahasiswa.show', compact('book', 'subCategories'));
    }
    public function profile()
    {
        // Mendapatkan mahasiswa yang sedang login
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->first();

        return view('dashboard.mahasiswa.profile', compact('mahasiswa'));
    }

    public function editMahasiswa($id)
    {
        // Mendapatkan mahasiswa yang sedang login
        $mahasiswa = Mahasiswa::where('user_id', $id)->first();

        return view('dashboard.mahasiswa.edit', compact('mahasiswa'));
    }

    public function updateMahasiswa(Request $request)
    {
        // Validasi data
        $request->validate([
            // Validasi untuk tabel `mahasiswas`
            'nim' => 'required|unique:mahasiswas,nim,' . $request->user_id . ',user_id',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:L,P',
            'program_studi' => 'required|string',
            'angkatan' => 'required|integer',
            'telepon' => 'nullable|string',

            // Validasi untuk tabel `users`
            'name' => 'required|string|max:255',
            'image' => 'nullable',
            'email' => 'required|email|unique:users,email,' . $request->user_id,
            'password' => 'nullable|confirmed|min:8',
        ]);

        // Temukan user berdasarkan `user_id` yang dikirim dari form
        $user = User::find($request->user_id);
        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'User tidak ditemukan.']);
        }

        // Perbarui data tabel `users`
        $user->name = $request->name;
        $user->email = $request->email;

        // Perbarui password jika diisi
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        // Perbarui data tabel `mahasiswas`
        $mahasiswa = $user->mahasiswa; // Relasi `User` ke `Mahasiswa`
        if (!$mahasiswa) {
            return redirect()->back()->withErrors(['error' => 'Mahasiswa tidak ditemukan.']);
        }

        $mahasiswa->update($request->only('nim', 'tanggal_lahir', 'jenis_kelamin', 'program_studi', 'angkatan', 'telepon'));

        return redirect()->back()->with('success', 'Profil dan akun berhasil diperbarui.');
    }


    public function updateProfile(Request $request)
    {
        $request->validate([
            // Validasi untuk tabel `mahasiswas`
            'nim' => 'required|unique:mahasiswas,nim,' . Auth::user()->mahasiswa->id,
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'required|in:L,P',
            'program_studi' => 'required|string',
            'angkatan' => 'required|integer',
            'telepon' => 'nullable|string',

            // Validasi untuk tabel `users`
            'name' => 'required|string|max:255',
            'image' => 'nullable',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'password' => 'nullable|confirmed|min:8',
        ]);

        // Perbarui data pada tabel `mahasiswas`
        $mahasiswa = Mahasiswa::where('user_id', Auth::id())->first();
        $mahasiswa->update($request->only('nim', 'tanggal_lahir', 'jenis_kelamin', 'program_studi', 'angkatan', 'telepon'));

        // Perbarui data pada tabel `users`
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;

        // Perbarui password hanya jika diisi
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        // $user->save();
        if($user->mahasiswa){
            $user->mahasiswa->save();
        }

        return redirect()->back()->with('success', 'Profil dan akun berhasil diperbarui.');
    }


    public function deleteAccount()
    {
        $user = Auth::user();

        // Hapus data mahasiswa dan akun pengguna
        $user->mahasiswa->delete();
        if ($user->mahasiswa) {
            $user->mahasiswa->delete();
        }

        // Logout setelah akun dihapus
        Auth::logout();

        return redirect('/')->with('success', 'Akun berhasil dihapus.');
    }
}
