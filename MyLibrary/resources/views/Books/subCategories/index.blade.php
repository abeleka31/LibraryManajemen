@php
    $layout = auth()->user()->role === 'admin' ? 'layouts.master' : 'layouts.masterStaff';
@endphp

@extends($layout)
@section('title', 'SubCategory')

@section('content')
    <div class="container mx-auto my-6 px-4">
        <h2 class="text-2xl font-semibold text-gray-700 mb-6">Daftar Sub Kategori</h2>

        <!-- Filter dan Pencarian -->
        <div class="mb-4 flex flex-wrap items-center gap-4">
            <div class="flex items-center w-full sm:w-auto">
                <label for="filter-category" class="mr-2">Filter Berdasarkan Kategori:</label>
                <select id="filter-category" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none w-full sm:w-auto">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center space-x-2 w-full sm:w-auto">
                <input type="text" id="search-input" placeholder="Cari Sub Kategori" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none w-full sm:w-auto" />
                <button onclick="showForm('tambah')" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 w-full sm:w-auto">
                    Tambah Sub Kategori
                </button>
            </div>
        </div>

        <!-- Kontainer untuk Tabel dan Form -->
        <div class="flex flex-col lg:flex-row gap-4">
            <!-- Tabel -->
            <div class="w-full lg:w-1/2 border border-gray-300 overflow-x-auto">
                <table id="pagination-table" class="w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">ID</th>
                            <th class="px-4 py-2 text-left">Sub Kategori</th>
                            <th class="px-4 py-2 text-left">Kategori</th>
                            <th class="px-4 py-2 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-body">
                        @foreach ($subCategories as $subCategory)
                            <tr class="border-b" data-category-id="{{ $subCategory->category->id }}" data-name="{{ $subCategory->name }}">
                                <td class="px-4 py-2">{{ $subCategory->id }}</td>
                                <td class="px-4 py-2">{{ $subCategory->name }}</td>
                                <td class="px-4 py-2">{{ $subCategory->category->name }}</td>
                                <td class="px-4 py-2">
                                    <button onclick="showForm('edit', {{ $subCategory->id }}, '{{ $subCategory->name }}', {{ $subCategory->category->id }})" class="text-blue-500 hover:underline">Edit</button>
                                    <form action="{{ route('subCategory.destroy', $subCategory->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Form input atau edit sub kategori -->
            <div class="w-full lg:w-1/2 border border-gray-300 p-4">
                <div id="form-container" class="hidden">
                    <h3 id="form-title" class="text-xl font-semibold mb-4">Tambah Sub Kategori</h3>
                    <form id="subcategory-form" method="POST" action="{{ route('subCategory.store') }}">
                        @csrf
                        <input type="hidden" id="subcategory-id" name="id">
                        <input type="hidden" name="_method" id="method-field"> <!-- Method field for PUT -->
                        <div class="mb-4">
                            <label for="subcategory-name" class="block text-sm font-medium text-gray-700">Nama Sub Kategori</label>
                            <input type="text" id="subcategory-name" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div class="mb-4">
                            <label for="category-select" class="block text-sm font-medium text-gray-700">Kategori</label>
                            <select id="category-select" name="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Simpan</button>
                        <button type="button" onclick="hideForm()" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 ml-2">Batal</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Fungsi untuk menampilkan form tambah atau edit
        function showForm(mode, id = null, name = '', categoryId = null) {
            const formContainer = document.getElementById('form-container');
            const formTitle = document.getElementById('form-title');
            const form = document.getElementById('subcategory-form');
            const subcategoryIdInput = document.getElementById('subcategory-id');
            const subcategoryNameInput = document.getElementById('subcategory-name');
            const categorySelect = document.getElementById('category-select');
            const methodField = document.getElementById('method-field');

            if (mode === 'tambah') {
                formTitle.textContent = 'Tambah Sub Kategori';
                form.action = '{{ route('subCategory.store') }}';
                methodField.value = '';
                subcategoryIdInput.value = '';
                subcategoryNameInput.value = '';
                categorySelect.value = '';
            } else if (mode === 'edit') {
                formTitle.textContent = 'Edit Sub Kategori';
                form.action = `{{ route('subCategory.update', ':id') }}`.replace(':id', id);
                methodField.value = 'PUT';
                subcategoryIdInput.value = id;
                subcategoryNameInput.value = name;
                categorySelect.value = categoryId;
            }

            formContainer.classList.remove('hidden');
        }

        function hideForm() {
            document.getElementById('form-container').classList.add('hidden');
        }

        // Fungsi untuk memfilter sub kategori berdasarkan kategori
        document.getElementById('filter-category').addEventListener('change', function() {
            const selectedCategoryId = this.value;
            const rows = document.querySelectorAll('#pagination-table tbody tr');

            rows.forEach(row => {
                const categoryId = row.getAttribute('data-category-id');

                if (selectedCategoryId === "" || selectedCategoryId === categoryId) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });

        // Fungsi untuk mencari sub kategori berdasarkan nama dan kategori terpilih
        document.getElementById('search-input').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const selectedCategoryId = document.getElementById('filter-category').value;
            const rows = document.querySelectorAll('#pagination-table tbody tr');

            rows.forEach(row => {
                const name = row.getAttribute('data-name').toLowerCase();
                const categoryId = row.getAttribute('data-category-id');

                if ((selectedCategoryId === "" || selectedCategoryId === categoryId) && name.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
@endpush
