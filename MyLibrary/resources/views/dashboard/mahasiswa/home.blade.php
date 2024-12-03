@extends('layouts.myLibraryMaster') <!-- Menggunakan layout master yang benar -->

@section('content')
    <div class="pt-36  bg-black border-2    border-dashed rounded-lg dark:border-gray-700 opacity-45" style="background-color: #ffffff">
        <h1 class="text-center text-2xl font-bold mb-6">Most Popular Books</h1>
        <div class="w-full  mb-6 flex justify-center relative dark:bg-gray-800 rounded-lg p-6 shadow-lg transition-shadow duration-300 ease-in-out hover:shadow-2xl">
            <!-- Container untuk Buku Terpopuler -->
            <div
                class="w-full  space-x-6  scroll-smooth snap-mandatory flex gap-4 overflow-x-auto scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-200 snap-x"
                id="popular-books-slider"
            >
                @php
                    // Ambil 5 buku dengan rating tertinggi
                    $popularBooks = $books->sortByDesc(function($book) {
                        return $book->averageRating() ?? 0;
                    })->take(10);
                @endphp

                @foreach ($popularBooks as $book)
                    <div class="flex-none w-64 flex flex-col items-center bg-gray-100 dark:bg-gray-800 rounded-lg p-4 shadow-lg snap-center transition-transform duration-300  transform hover:scale-105">
                        <!-- Gambar Buku -->
                        <div class="relative w-40 h-60 bg-gray-300 rounded-lg overflow-hidden mb-4">
                            <img
                                src="{{ $book->image ? asset('storage/' . $book->image) : 'https://via.placeholder.com/150x200.png?text=No+Image' }}"
                                alt="Gambar Buku"
                                class="w-full h-full object-cover"
                            >
                        </div>
                        <!-- Informasi Buku -->
                        <h3 class="font-semibold text-gray-800 dark:text-white text-center mb-2">{{ $book->name }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 text-center">Penulis: {{ $book->penulis }}</p>
                        <!-- Rating -->
                        <div class="flex justify-center items-center mt-2">
                            @php $rating = $book->averageRating() ?? 0; @endphp
                            @for ($i = 1; $i <= 5; $i++)
                                <svg
                                    class="w-5 h-5 {{ $i <= $rating ? 'text-yellow-400' : 'text-gray-300' }}"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path d="M12 .587l3.668 7.455 8.332 1.214-6.001 5.854 1.416 8.261L12 18.897l-7.415 3.964 1.416-8.261-6.001-5.854 8.332-1.214z" />
                                </svg>
                            @endfor
                        </div>
                        <!-- Tombol Lihat -->
                        <a
                            href="{{ route('books.show', $book->id) }}"
                            class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg shadow-lg hover:bg-blue-700 transition text-sm"
                        >
                            Lihat
                        </a>
                    </div>
                @endforeach
            </div>
        </div>


        <!-- Hero Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
            <!-- Quotes Section -->
            <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-6 shadow-lg transition-shadow duration-300 ease-in-out hover:shadow-2xl"
                 style="background-image: url('https://images.unsplash.com/photo-1510172951991-856a654063f9?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'); background-attachment: scroll; background-position: center; background-size: cover;">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Quotes of the Day</h2>
                <blockquote class="italic text-gray-600 dark:text-gray-300">
                    "The only limit to our realization of tomorrow is our doubts of today." - Franklin D. Roosevelt
                </blockquote>
            </div>

            <!-- Latest Books Section -->
            <div class=" dark:bg-gray-800 rounded-lg p-6 shadow-lg transition-shadow duration-300 ease-in-out hover:shadow-2xl" >
                <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Buku Terbaru</h2>
                <!-- Kontainer Scroll Horizontal -->
                <div class="flex gap-4 overflow-x-auto scrollbar-thin scrollbar-thumb-gray-400 scrollbar-track-gray-200 snap-x" >
                    @foreach ($books->take(10) as $book)
                    <div class="flex flex-col items-center bg-white dark:bg-gray-900 rounded-lg p-2 shadow-md w-[100px] h-auto snap-center transition-transform duration-300 ease-in-out hover:scale-105" style="background-color: #F1F0E8">
                        <!-- Gambar Buku (Rasio 2:3) -->
                        <div class="relative w-24 h-36 bg-gray-300 dark:bg-gray-600 rounded-lg overflow-hidden mb-2">
                            <img src="{{ $book->image ? asset('storage/' . $book->image) : 'https://via.placeholder.com/100x150.png?text=No+Image' }}"
                                 alt="Gambar Buku" class="w-full h-full object-cover">
                        </div>
                        {{-- keterangan buku --}}
                        <div>
                            <!-- Judul Buku -->
                            <p class="font-semibold text-gray-700 dark:text-white text-[0.5rem] leading-tight text-center w-full break-words"
                            style="width: calc(12ch + 1em);" title="{{ $book->name }}">
                                {{ $book->name }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Book List Section -->
        <div class="w-full my-20 p-6">
            <div class="bg-white p-6 rounded-lg shadow-md transition-shadow duration-300 ease-in-out hover:shadow-2xl" style="background-color: #E5E1DA">
                <h2 class="text-2xl font-semibold text-gray-700 mb-6">Daftar Buku</h2>

                <!-- Search Form -->
                <form id="search-form" class="mb-6 flex flex-wrap justify-between space-x-4">
                    <div class="flex flex-wrap justify-between space-x-4 w-full">
                        <div class="w-full sm:w-1/3">
                            <label for="search_input" class="block text-sm font-medium text-gray-700">Cari Buku</label>
                            <input type="text" id="search_input" class="w-full p-2 border border-gray-300 rounded-md transition-all duration-300 ease-in-out focus:ring-2 focus:ring-blue-500 focus:outline-none" placeholder="Cari Buku..." />
                        </div>
                    </div>
                </form>

                <!-- Book Grid List -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" id="book-grid">
                    @foreach ($books as $book)
                        <div class=" p-4 rounded-lg shadow-md transition-all duration-300 ease-in-out transform hover:scale-105 hover:shadow-xl flex items-center book-item"
                             data-name="{{ strtolower($book->name) }}"
                             data-author="{{ strtolower($book->penulis) }}" style="background-color: #F1F0E8" >
                            <!-- Gambar Buku -->
                            <div class="flex-shrink-0 relative w-32 h-48 bg-gray-300 dark:bg-gray-600 rounded-lg overflow-hidden">
                                <img src="{{ $book->image ? asset('storage/' . $book->image) : 'https://via.placeholder.com/100x150.png?text=No+Image' }}"
                                     alt="Book Image" class="w-full h-full object-cover">
                            </div>

                            <!-- Keterangan Buku -->
                            <div class="ml-4 flex flex-col justify-between h-full w-full">
                                <!-- Keterangan -->
                                <div>
                                    <a href="{{ route('dashboard.mahasiswa.show', ['id' => $book->id]) }}"
                                       class="font-semibold text-gray-800 transition-all duration-300 ease-in-out hover:text-blue-600 block text-lg">
                                        {{ $book->name }}
                                    </a>
                                    <p class="text-sm text-gray-600 transition-all duration-300 ease-in-out hover:text-gray-800">
                                        Penulis: {{ $book->penulis }}
                                    </p>

                                    <!-- Rating dengan Bintang -->
                                    <div class="flex items-center mt-2">
                                        @php
                                            $rating = $book->averageRating() ?? 0; // Rating rata-rata
                                        @endphp

                                        <div class="flex space-x-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <div class="relative">
                                                    <!-- Bintang Kosong -->
                                                    <svg class="w-6 h-6 text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                                        <path d="M12 .587l3.668 7.455 8.332 1.214-6.001 5.854 1.416 8.261L12 18.897l-7.415 3.964 1.416-8.261-6.001-5.854 8.332-1.214z" />
                                                    </svg>

                                                    <!-- Pengisian Bintang -->
                                                    <div class="absolute top-0 left-0 h-full overflow-hidden" style="width: {{ max(0, min(1, $rating - $i + 1)) * 100 }}%;">
                                                        <svg class="w-6 h-6 text-yellow-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                                            <path d="M12 .587l3.668 7.455 8.332 1.214-6.001 5.854 1.416 8.261L12 18.897l-7.415 3.964 1.416-8.261-6.001-5.854 8.332-1.214z" />
                                                        </svg>
                                                    </div>
                                                </div>
                                            @endfor
                                        </div>
                                    </div>

                                    <p class="text-sm text-gray-600 mt-1">
                                        Stok: {{ $book->jumlahStock }}
                                    </p>
                                </div>

                                <!-- Tombol Aksi -->
                                <div class="flex mt-4 space-x-2">
                                    <a href="{{ route('dashboard.mahasiswa.show', ['id' => $book->id]) }}"
                                       class="px-4 py-2 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600 transition duration-300 ease-in-out">
                                        Lihat
                                    </a>
                                    <a href="{{ route('peminjaman.propose', $book->id) }}"
                                       class="px-4 py-2 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 transition duration-300 ease-in-out">
                                        Pinjam
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search_input');
            const bookItems = document.querySelectorAll('.book-item');

            searchInput.addEventListener('input', function() {
                const query = searchInput.value.toLowerCase();

                bookItems.forEach(item => {
                    const bookName = item.getAttribute('data-name');
                    const bookAuthor = item.getAttribute('data-author');

                    if (bookName.includes(query) || bookAuthor.includes(query)) {
                        item.style.display = ''; // Show
                    } else {
                        item.style.display = 'none'; // Hide
                    }
                });
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            const slider = document.getElementById('popular-books-slider');
            const prev = document.getElementById('prev-slide');
            const next = document.getElementById('next-slide');

            let scrollAmount = 0;
            const slideWidth = slider.children[0].clientWidth + 24; // Adjust based on spacing

            prev.addEventListener('click', () => {
                scrollAmount = Math.max(scrollAmount - slideWidth, 0);
                slider.scrollTo({
                    left: scrollAmount,
                    behavior: 'smooth'
                });
            });

            next.addEventListener('click', () => {
                scrollAmount = Math.min(scrollAmount + slideWidth, slider.scrollWidth - slider.clientWidth);
                slider.scrollTo({
                    left: scrollAmount,
                    behavior: 'smooth'
                });
            });
        });
    </script>
@endsection
