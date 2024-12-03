@extends('layouts.mastermahasiswa')

@section('content')
    <div class="container mx-auto mt-8 px-4">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 ease-in-out">
            <h1 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">Ajukan Peminjaman Buku</h1>

            <!-- Modal Batas Peminjaman -->
            @if(session('limitReached'))
                <div class="fixed inset-0 flex items-center justify-center z-50">
                    <div class="bg-gray-800 bg-opacity-50 absolute inset-0"></div>
                    <div class="bg-white p-6 rounded-lg shadow-lg z-10 max-w-sm mx-auto">
                        <h2 class="text-xl font-semibold text-red-500">Batas Peminjaman Tercapai</h2>
                        <p class="mt-4 text-gray-700">
                            Anda telah mencapai batas maksimal peminjaman (5).
                            Selesaikan pengembalian buku terlebih dahulu untuk dapat meminjam buku baru.
                        </p>
                        <button onclick="window.history.back()" class="mt-4 w-full bg-red-500 text-white py-2 rounded-lg hover:bg-red-600 transition-all duration-300 ease-in-out">
                            Kembali
                        </button>
                    </div>
                </div>
            @endif
            @if($book->jumlahStock <= 0)
                <!-- Modal Stok Habis -->
                <div class="fixed inset-0 flex items-center justify-center z-50">
                    <div class="bg-gray-800 bg-opacity-50 absolute inset-0"></div>
                    <div class="bg-white p-6 rounded-lg shadow-lg z-10 max-w-sm mx-auto">
                        <h2 class="text-xl font-semibold text-red-500">Stok Buku Habis</h2>
                        <p class="mt-4 text-gray-700">Mohon maaf, stok buku ini saat ini tidak tersedia.</p>
                        <button onclick="window.history.back()" class="mt-4 w-full bg-red-500 text-white py-2 rounded-lg hover:bg-red-600 transition-all duration-300 ease-in-out">
                            Kembali
                        </button>
                    </div>
                </div>
            @else
                <!-- Formulir pengajuan peminjaman -->
                <form action="{{ route('loan.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Input tersembunyi untuk mahasiswa_id -->
                    <input type="hidden" name="mahasiswa_id" value="{{$mahasiswa->id}}">

                    <!-- Input tersembunyi untuk book_id -->
                    <input type="hidden" name="book_id" value="{{ $book->id }}">

                    <!-- Menampilkan Gambar Buku -->
                    <div class="relative w-full" style="max-width: 30%; height: 0; padding-top: 45%; margin-bottom: 1rem;">
                        <img src="{{ $book->image ? asset('storage/' . $book->image) : 'https://via.placeholder.com/100x150.png?text=No+Image' }}"
                             alt="Gambar Buku" class="absolute top-0 left-0 w-full h-full object-cover rounded-lg shadow-md transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-lg">
                    </div>

                    <!-- Menampilkan Nama Mahasiswa -->
                    <div>
                        <h2 class="text-lg font-medium text-gray-700 dark:text-gray-200">Nama Peminjam: {{ $mahasiswa->user->name }}</h2>
                    </div>

                    <!-- Menampilkan Nama Buku -->
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Judul Buku: {{ $book->name }}</h3>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Category: {{ $book->subCategory->category->name }}</h3>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Sub Category: {{ $book->subCategory->name }}</h3>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-white">Jumlah Stok: {{ $book->jumlahStock }}</h3>
                    </div>

                    <!-- Input Tanggal Pengembalian -->
                    <div>
                        <label for="required_date" class="text-gray-700 dark:text-gray-300 mb-2 block text-sm">Masukkan Tanggal Pengembalian</label>
                        <input type="date" name="required_date" id="required_date" class="w-full p-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm">
                    </div>

                    <!-- Tombol Ajukan Peminjaman -->
                    <div>
                        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-700 transition-all duration-300 ease-in-out text-sm">
                            Ajukan Peminjaman
                        </button>
                    </div>
                </form>
            @endif

            <!-- Tombol Batal yang mengarah ke halaman sebelumnya -->
            <div class="mt-4">
                <button onclick="window.history.back();" class="w-full bg-gray-400 text-white py-2 rounded-lg hover:bg-gray-500 transition-all duration-300 ease-in-out text-sm">
                    Batal
                </button>
            </div>
        </div>
    </div>
@endsection
