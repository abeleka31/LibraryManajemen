@extends('layouts.masterMahasiswa')

@section('title', 'Detail Buku')

@section('content')
    <div class="pt-20"> <!-- Memberikan padding-top agar tidak tertutupi navbar -->
        <div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-lg transition-transform transform hover:scale-105 duration-300">
            <!-- Judul Halaman -->
            <h1 class="text-3xl font-semibold text-gray-800 mb-6 animate__animated animate__fadeIn animate__delay-1s">📖 Detail Buku: {{ $book->name }}</h1>

            <!-- Gambar Buku -->
            <div class="flex justify-center mb-6 transition-transform transform hover:scale-110 duration-300">
                @if ($book->image)
                    <img src="{{ asset('storage/' . $book->image) }}" alt="Gambar Buku" class="w-72 h-96 object-cover rounded-xl shadow-md">
                @else
                    <img src="{{ asset('images/default-book.png') }}" alt="Gambar Buku Default" class="w-72 h-96 object-cover rounded-xl shadow-md">
                @endif
            </div>

            <!-- Informasi Buku -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 animate__animated animate__fadeIn animate__delay-1.5s">
                <div class="bg-gray-50 p-4 rounded-xl shadow-sm hover:bg-gray-100 transition-all duration-300">
                    <strong class="text-gray-700">Penulis:</strong>
                    <p class="text-gray-600">{{ $book->penulis }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl shadow-sm hover:bg-gray-100 transition-all duration-300">
                    <strong class="text-gray-700">Penerbit:</strong>
                    <p class="text-gray-600">{{ $book->penerbit }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl shadow-sm hover:bg-gray-100 transition-all duration-300">
                    <strong class="text-gray-700">Tahun Terbit:</strong>
                    <p class="text-gray-600">{{ $book->tahunTerbit }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl shadow-sm hover:bg-gray-100 transition-all duration-300">
                    <strong class="text-gray-700">ISBN:</strong>
                    <p class="text-gray-600">{{ $book->ISBN }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl shadow-sm hover:bg-gray-100 transition-all duration-300">
                    <strong class="text-gray-700">Jumlah Stok:</strong>
                    <p class="text-gray-600">{{ $book->jumlahStock }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl shadow-sm hover:bg-gray-100 transition-all duration-300">
                    <strong class="text-gray-700">rating:</strong>
                    <p class="text-gray-600">{{ $book->averageRating() }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl shadow-sm hover:bg-gray-100 transition-all duration-300">
                    <strong class="text-gray-700">Sub Kategori:</strong>
                    <p class="text-gray-600">{{ $book->subCategory->name ?? 'Tidak ada' }}</p>
                </div>
                <div class="bg-gray-50 p-4 rounded-xl shadow-sm hover:bg-gray-100 transition-all duration-300">
                    <strong class="text-gray-700">Status:</strong>
                    <span class="px-3 py-1 rounded-full {{ $book->status == 'tersedia' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                        {{ ucfirst($book->status) }}
                    </span>
                </div>
                <div class="col-span-2 bg-gray-50 p-4 rounded-xl shadow-sm hover:bg-gray-100 transition-all duration-300">
                    <strong class="text-gray-700">Deskripsi:</strong>
                    <p class="text-gray-600">{{ $book->description }}</p>
                </div>
            </div>

            <!-- Tombol Pinjam -->
            <div class="mt-6 text-right">
                <a href="#" class="px-6 py-3 bg-blue-500 text-white rounded-xl transition-all hover:bg-blue-600 transform hover:scale-105 duration-300">
                    Pinjam Buku
                </a>
            </div>
            <div class="mt-4">
                <button onclick="window.history.back();" class="w-full bg-gray-400 text-white py-2 rounded-lg hover:bg-gray-500 transition-all duration-300 ease-in-out text-sm">
                    Batal
                </button>
            </div>
        </div>
    </div>
@endsection
