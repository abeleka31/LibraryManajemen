<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Model User untuk admin
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminCrudController extends Controller
{
    public function adminHome()
    {
        return view('dashboard.admin.home');
    }

    public function index()
    {
        // Mengambil semua data admin
        $admins = User::where('role', 'admin')->get();
        return view('dashboard.admin.crud', compact('admins'));
    }

    public function store(Request $request)
    {
        // Validasi permintaan
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        // Simpan gambar jika ada
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('admin-images');
        }

        // Buat admin baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $imagePath,
            'role' => 'admin',
        ]);

        return redirect()->route('admin.crud')->with('success', 'Admin berhasil dibuat!');
    }

    public function edit($id)
    {
        $admin = User::findOrFail($id);
        return view('dashboard.admin.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);

        // Validasi permintaan
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'password' => 'nullable|min:6',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        // Perbarui detail admin
        $admin->name = $request->name;
        $admin->email = $request->email;

        // Perbarui password jika diisi
        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        // Perbarui gambar jika diunggah
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($admin->image) {
                Storage::delete($admin->image);
            }

            $admin->image = $request->file('image')->store('admin-images');
        }

        $admin->save();

        return redirect()->route('admin.crud')->with('success', 'Admin berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $admin = User::findOrFail($id);

        // Hapus gambar dari penyimpanan jika ada
        if ($admin->image) {
            Storage::delete($admin->image);
        }

        $admin->delete();

        return redirect()->route('admin.crud')->with('success', 'Admin berhasil dihapus!');
    }
}
