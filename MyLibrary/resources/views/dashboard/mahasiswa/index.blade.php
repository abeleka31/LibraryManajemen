@extends('layouts.myLibraryMaster')

@section('content')
    <div class="w-full my-20 p-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Daftar Buku</h2>

            <!-- Form Pencarian -->
            <form id="search-form" class="mb-6 flex flex-wrap justify-between space-x-4">
                <div class="flex flex-wrap justify-between space-x-4 w-full">
                    <!-- Dropdown Kategori -->
                    <div class="w-full sm:w-1/3">
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                        <select name="category_id" id="category_id" class="w-full p-2 border border-gray-300 rounded-md">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Dropdown Subkategori -->
                    <div class="w-full sm:w-1/3">
                        <label for="sub_category_id" class="block text-sm font-medium text-gray-700">Subkategori</label>
                        <select name="sub_category_id" id="sub_category_id" class="w-full p-2 border border-gray-300 rounded-md">
                            <option value="">Pilih Subkategori</option>
                        </select>
                    </div>

                    <!-- Pencarian Buku -->
                    <div class="w-full sm:w-1/3">
                        <label for="search_input" class="block text-sm font-medium text-gray-700">Cari Buku</label>
                        <input type="text" id="search_input" class="w-full p-2 border border-gray-300 rounded-md" placeholder="Cari Buku...">
                    </div>

                    <!-- Tombol Cari -->
                    <div class="pt-7 w-full sm:w-auto">
                        <button type="button" id="reset-btn" class="px-6 py-2 bg-gray-300 text-black rounded-lg">Reset</button>
                    </div>
                </div>
            </form>

            <!-- Tabel Daftar Buku -->
            <div class="overflow-x-auto bg-white shadow rounded-lg">
                <table id="book-table" class="w-full text-sm text-left text-gray-500">
                    <thead class="bg-gray-100 text-gray-700 font-semibold">
                        <tr>
                            <th class="px-6 py-3">Katalog Buku</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="book-table-body">
                        @foreach ($books as $book)
                            <tr class="book-row border-b hover:bg-gray-50"
                                data-category="{{ $book->subCategory->category->id }}"
                                data-subcategory="{{ $book->subCategory->id }}"
                                data-name="{{ strtolower($book->name) }}"
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
                                    <a href="{{ route('dashboard.mahasiswa.show', $book->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600 transition">View</a>
                                    <button class="px-4 py-2 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 transition">Pinjam</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <footer class="bg-gray-800 text-white py-4 text-center w-full">
        <p>&copy; 2024 Perpustakaan Digital. Semua Hak Dilindungi.</p>
    </footer>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const categories = @json($categories);
            const subCategories = @json($subCategories);
            const books = @json($books);

            const categorySelect = document.getElementById('category_id');
            const subCategorySelect = document.getElementById('sub_category_id');
            const searchInput = document.getElementById('search_input');
            const bookTableBody = document.getElementById('book-table-body');
            const resetButton = document.getElementById('reset-btn');

            // Update subcategories when category is selected
            categorySelect.addEventListener('change', function () {
                const selectedCategoryId = this.value;

                // Clear subcategory dropdown
                subCategorySelect.innerHTML = '<option value="">Pilih Subkategori</option>';

                if (selectedCategoryId) {
                    const filteredSubCategories = subCategories.filter(subCategory => subCategory.category_id == selectedCategoryId);

                    filteredSubCategories.forEach(subCategory => {
                        const option = document.createElement('option');
                        option.value = subCategory.id;
                        option.textContent = subCategory.name;
                        subCategorySelect.appendChild(option);
                    });

                    filterBooks();
                } else {
                    filterBooks();
                }
            });

            // Filter books by category and subcategory
            function filterBooks() {
                const selectedCategoryId = categorySelect.value;
                const selectedSubCategoryId = subCategorySelect.value;
                const searchText = searchInput.value.toLowerCase();

                const rows = bookTableBody.querySelectorAll('.book-row');
                rows.forEach(row => {
                    const bookCategoryId = row.dataset.category;
                    const bookSubCategoryId = row.dataset.subcategory;
                    const bookName = row.dataset.name;
                    const bookAuthor = row.dataset.author;

                    if (
                        (selectedCategoryId && selectedCategoryId != bookCategoryId) ||
                        (selectedSubCategoryId && selectedSubCategoryId != bookSubCategoryId) ||
                        (searchText && !bookName.includes(searchText) && !bookAuthor.includes(searchText))
                    ) {
                        row.style.display = 'none';
                    } else {
                        row.style.display = '';
                    }
                });
            }

            subCategorySelect.addEventListener('change', filterBooks);
            searchInput.addEventListener('input', filterBooks);

            resetButton.addEventListener('click', function () {
                categorySelect.value = '';
                subCategorySelect.innerHTML = '<option value="">Pilih Subkategori</option>';
                searchInput.value = '';
                filterBooks();
            });
        });
    </script>
@endsection
