@extends('layouts.myLibraryMaster')

@section('content')
<div class="container mx-auto mt-8 px-4 pt-20" >
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 ease-in-out">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">Profil Mahasiswa</h1>

        <!-- Pesan sukses -->
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Formulir Profil -->
        <form action="{{ route('mahasiswa.updateProfile') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Formulir Tabel Mahasiswa -->
            <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Informasi Mahasiswa</h2>

                <!-- NIM -->
                <div>
                    <label for="nim" class="block text-gray-700 dark:text-gray-300">NIM</label>
                    <input type="text" name="nim" id="nim" value="{{ $mahasiswa->nim }}" required
                        class="w-full p-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-white">
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label for="tanggal_lahir" class="block text-gray-700 dark:text-gray-300">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ $mahasiswa->tanggal_lahir }}"
                        class="w-full p-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-white">
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label for="jenis_kelamin" class="block text-gray-700 dark:text-gray-300">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin"
                        class="w-full p-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-white">
                        <option value="L" {{ $mahasiswa->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ $mahasiswa->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <!-- Program Studi -->
                <div>
                    <label for="program_studi" class="block text-gray-700 dark:text-gray-300">Program Studi</label>
                    <input type="text" name="program_studi" id="program_studi" value="{{ $mahasiswa->program_studi }}" required
                        class="w-full p-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-white">
                </div>

                <!-- Angkatan -->
                <div>
                    <label for="angkatan" class="block text-gray-700 dark:text-gray-300">Angkatan</label>
                    <input type="number" name="angkatan" id="angkatan" value="{{ $mahasiswa->angkatan }}" required
                        class="w-full p-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-white">
                </div>

                <!-- Telepon -->
                <div>
                    <label for="telepon" class="block text-gray-700 dark:text-gray-300">Telepon</label>
                    <input type="text" name="telepon" id="telepon" value="{{ $mahasiswa->telepon }}"
                        class="w-full p-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-white">
                </div>
            </div>

            <!-- Formulir Tabel Users -->
            <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Informasi Akun</h2>

                <!-- Nama -->
                <div>
                    <label for="name" class="block text-gray-700 dark:text-gray-300">Nama</label>
                    <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" required
                        class="w-full p-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-white">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-gray-700 dark:text-gray-300">Email</label>
                    <input type="email" name="email" id="email" value="{{ Auth::user()->email }}" required
                        class="w-full p-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-white">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-gray-700 dark:text-gray-300">Password Baru (Opsional)</label>
                    <input type="password" name="password" id="password"
                        class="w-full p-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-white">
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="password_confirmation" class="block text-gray-700 dark:text-gray-300">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full p-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-white">
                </div>
            </div>

            <!-- Tombol Simpan -->
            <div>
                <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-700 transition-all duration-300 ease-in-out">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
