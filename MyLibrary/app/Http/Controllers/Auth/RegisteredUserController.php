<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
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
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
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

        // Menyimpan event pengguna terdaftar
        event(new Registered($user));

        // Login otomatis dan redirect ke dashboard
        Auth::login($user);

        return redirect(route('dashboard'));
    }
}
