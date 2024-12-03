@extends('layouts.master') <!-- Menggunakan layout master.blade.php -->

@section('title', 'Edit Staff') <!-- Menentukan judul halaman -->

@section('content') <!-- Konten utama halaman -->
<div class="flex justify-center items-center min-h-screen bg-gray-50">
    <div class="w-full max-w-4xl bg-white rounded-lg shadow-lg p-8 md:p-12">
        <h2 class="text-3xl font-semibold text-center text-gray-900 mb-6">Edit Staff</h2>

        <!-- Formulir Edit Staff -->
        <form action="{{ route('staff.update', $staff->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">

                <!-- Nama -->
                <div>
                    <label for="name" class="block text-lg font-medium text-gray-700">Nama</label>
                    <input type="text" id="name" name="name" value="{{ $staff->user->name }}" required
                        class="mt-2 block w-full px-4 py-3 text-lg rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 transition-all focus:ring-2">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-lg font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" value="{{ $staff->user->email }}" required
                        class="mt-2 block w-full px-4 py-3 text-lg rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 transition-all focus:ring-2">
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label for="gender" class="block text-lg font-medium text-gray-700">Jenis Kelamin</label>
                    <select id="gender" name="gender" required
                        class="mt-2 block w-full px-4 py-3 text-lg rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 transition-all focus:ring-2">
                        <option value="Laki Laki" {{ $staff->gender == 'Laki Laki' ? 'selected' : '' }}>Laki Laki</option>
                        <option value="Perempuan" {{ $staff->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <!-- No Telepon -->
                <div>
                    <label for="no_telepon" class="block text-lg font-medium text-gray-700">No Telepon</label>
                    <input type="text" id="no_telepon" name="no_telepon" value="{{ $staff->no_telepon }}" required
                        class="mt-2 block w-full px-4 py-3 text-lg rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 transition-all focus:ring-2">
                </div>

                <!-- Tombol Submit -->
                <div>
                    <button type="submit"
                        class="w-full py-4 text-lg font-semibold bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-colors duration-300">
                        Update
                    </button>
                </div>

                <!-- Tombol Batal -->
                <div class="mt-4">
                    <a href="{{ url()->previous() }}" class="flex items-center text-red-500 hover:text-red-700 font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
