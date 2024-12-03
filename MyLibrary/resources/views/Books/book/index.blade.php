@php
    $layout = auth()->user()->role === 'admin' ? 'layouts.master' : 'layouts.masterStaff';
@endphp

@extends($layout)
@section('title', 'Daftar Buku')

@section('content')
    <div class="container mx-auto my-8 p-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Daftar Buku</h2>
            <a href="{{ route('books.create') }}" class="inline-block px-6 py-2 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 mb-4 transition">Tambah Buku</a>

            <!-- Filter dan Pencarian -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                <div class="flex items-center">
                    <label for="filter-category" class="mr-2 text-sm">Filter Berdasarkan Kategori:</label>
                    <select id="filter-category" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none w-full sm:w-auto">
                        <option value="">Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center">
                    <label for="filter-subcategory" class="mr-2 text-sm">Filter Berdasarkan Subkategori:</label>
                    <select id="filter-subcategory" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none w-full sm:w-auto" disabled>
                        <option value="">Pilih Subkategori</option>
                    </select>
                </div>

                <div class="flex items-center">
                    <label for="search" class="mr-2 text-sm">Cari Judul atau Author:</label>
                    <input type="text" id="search" placeholder="Masukkan kata kunci..." class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none w-full sm:w-auto">
                </div>
            </div>

            <!-- Tabel Daftar Buku -->
            <div class="overflow-x-auto bg-white shadow rounded-lg">
                <table id="book-table" class="min-w-full text-sm text-left text-gray-500">
                    <thead class="bg-gray-100 text-gray-700 font-semibold">
                        <tr>
                            <th class="px-6 py-3">Katalog Buku</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="book-table-body">
                        @foreach ($books as $book)
                            <tr class="book-row border-b hover:bg-gray-50"
                                data-category="{{ $book->subCategory->category_id }}"
                                data-subcategory="{{ $book->subCategory->id }}"
                                data-title="{{ strtolower($book->name) }}"
                                data-author="{{ strtolower($book->penulis) }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-4">
                                        @if ($book->image)
                                            <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->name }}" class="w-24 h-36 object-cover rounded mr-4">
                                        @else
                                            <img src="https://via.placeholder.com/150" alt="Gambar Tidak Tersedia" class="w-20 h-20 object-cover rounded mr-4">
                                        @endif
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-800">{{ $book->name }}</h3>
                                            <p class="text-sm text-gray-600">Penulis: {{ $book->penulis }}</p>
                                            <p class="text-sm text-gray-600">Status: {{ $book->status }}</p>
                                            <p class="text-sm text-gray-600">Tanggal Ditambahkan: {{ $book->created_at->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center space-x-2">
                                    <a href="{{ route('books.edit', $book->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg font-semibold hover:bg-yellow-600 transition">Edit</a>
                                    <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg font-semibold hover:bg-red-600 transition" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const categorySelect = document.getElementById("filter-category");
        const subCategorySelect = document.getElementById("filter-subcategory");
        const searchInput = document.getElementById("search");
        const bookRows = document.querySelectorAll('.book-row');

        const subCategories = @json($subCategories);

        // Event listener untuk filter kategori
        categorySelect.addEventListener('change', function() {
            const selectedCategory = this.value;

            // Reset subkategori
            subCategorySelect.innerHTML = '<option value="">Pilih Subkategori</option>';
            subCategorySelect.disabled = true;

            if (selectedCategory) {
                // Filter subkategori berdasarkan kategori yang dipilih
                const filteredSubCategories = subCategories.filter(sc => sc.category_id == selectedCategory);
                filteredSubCategories.forEach(sc => {
                    const option = document.createElement('option');
                    option.value = sc.id;
                    option.textContent = sc.name;
                    subCategorySelect.appendChild(option);
                });

                subCategorySelect.disabled = false;
            }

            filterBooks(); // Update tampilan buku
        });

        // Event listener untuk filter subkategori
        subCategorySelect.addEventListener('change', filterBooks);

        // Event listener untuk pencarian
        searchInput.addEventListener('input', filterBooks);

        // Fungsi untuk menyaring buku berdasarkan kategori, subkategori, dan pencarian
        function filterBooks() {
            const selectedCategory = categorySelect.value;
            const selectedSubcategory = subCategorySelect.value;
            const searchTerm = searchInput.value.toLowerCase();

            bookRows.forEach(row => {
                const rowCategory = row.getAttribute('data-category');
                const rowSubcategory = row.getAttribute('data-subcategory');
                const rowTitle = row.getAttribute('data-title');
                const rowAuthor = row.getAttribute('data-author');

                // Filter logika
                const matchesCategory = !selectedCategory || rowCategory === selectedCategory;
                const matchesSubcategory = !selectedSubcategory || rowSubcategory === selectedSubcategory;
                const matchesSearch = !searchTerm || rowTitle.includes(searchTerm) || rowAuthor.includes(searchTerm);

                if (matchesCategory && matchesSubcategory && matchesSearch) {
                    row.style.display = ''; // Tampilkan baris
                } else {
                    row.style.display = 'none'; // Sembunyikan baris
                }
            });
        }

        // Inisialisasi filter
        filterBooks();
    });
</script>
@endpush
