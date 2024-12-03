@extends('layouts.master')

@section('title', 'Tambah Staff')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50">
    <main class="w-full h-full p-6 bg-white rounded-lg shadow-lg max-w-full max-h-full">
        <h2 class="text-3xl font-semibold mb-6 text-gray-800">Tambah Staff</h2>
        <form action="{{ route('staff.store') }}" method="POST">
            @csrf
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Nama</label>
                    <input type="text" id="name" name="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 transition duration-200 ease-in-out" placeholder="John" required />
                </div>
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 transition duration-200 ease-in-out" placeholder="john.doe@company.com" required />
                </div>
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 transition duration-200 ease-in-out" placeholder="•••••••••" required />
                </div>
                <div>
                    <label for="gender" class="block mb-2 text-sm font-medium text-gray-700">Jenis Kelamin</label>
                    <select id="gender" name="gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 transition duration-200 ease-in-out" required>
                        <option value="Laki Laki">Laki Laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div>
                    <label for="no_telepon" class="block mb-2 text-sm font-medium text-gray-700">No Telepon</label>
                    <input type="text" id="no_telepon" name="no_telepon" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 transition duration-200 ease-in-out" placeholder="123-45-678" required />
                </div>
            </div>

            <div class="flex justify-between">
                <button type="submit" class="text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center transition duration-300 ease-in-out">
                    Simpan
                </button>
                <a href="{{ url()->previous() }}" class="flex items-center text-red-600 hover:text-red-700 font-medium transition duration-200 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    Batal
                </a>
            </div>
        </form>
    </main>
</div>
@endsection





