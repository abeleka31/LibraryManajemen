@php
    $layout = auth()->user()->role === 'admin' ? 'layouts.master' : 'layouts.masterStaff';
@endphp

@extends($layout)

@section('title', 'Daftar Kategori')

@push('styles')
    <!-- Flowbite CSS -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.css" rel="stylesheet">

    <!-- Simple Datatables CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css">
@endpush

@section('content')
    <div class="container mx-auto my-6">
        <h2 class="text-2xl font-semibold text-gray-700 mb-6">Daftar Kategori</h2>
        <button onclick="showForm('tambah')" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Tambah Kategori
        </button>

        <div class="flex h-[500px] space-x-4">
            <div class="w-1/2 h-full border border-gray-300 overflow-auto">
                <table id="pagination-table" class="w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">ID</th>
                            <th class="px-4 py-2 text-left">Category</th>
                            <th class="px-4 py-2 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-body">
                        @foreach ($categories as $category)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $category->id }}</td>
                            <td class="px-4 py-2">{{ $category->name }}</td>
                            <td class="px-4 py-2">
                                <button onclick="showForm('edit', {{ $category->id }}, '{{ $category->name }}')" class="text-blue-500 hover:underline">Edit</button>
                                <form action="{{ route('category.destroy', $category->id) }}" method="POST" class="inline-block">
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
            <div class="w-1/2 h-full border border-gray-300 p-4">
                <div id="form-container" class="hidden">
                    <h3 id="form-title" class="text-xl font-semibold mb-4">Tambah Kategori</h3>
                    <form id="category-form" method="POST" action="{{ route('category.store') }}">
                        @csrf
                        <input type="hidden" id="category-id" name="id">
                        <input type="hidden" name="_method" id="method-field"> <!-- Method field for PUT -->
                        <div class="mb-4">
                            <label for="category-name" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                            <input type="text" id="category-name" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Simpan</button>
                        <button type="button" onclick="hideForm()" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 ml-2">Batal</button>
                    </form>
                </div>
                <p class="mt-4">Jumlah kategori: {{ $categories->count() }}</p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Flowbite JS -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.js"></script>

    <!-- Simple Datatables JS -->
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"></script>

    <script>
        if (document.getElementById("pagination-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#pagination-table", {
                paging: true,
                perPage: 5,
                perPageSelect: [5, 10, 15, 20, 25],
                sortable: false
            });
        }

        // JavaScript untuk menampilkan dan menyembunyikan form
        function showForm(mode, id = null, name = '') {
            const formContainer = document.getElementById('form-container');
            const formTitle = document.getElementById('form-title');
            const form = document.getElementById('category-form');
            const categoryIdInput = document.getElementById('category-id');
            const categoryNameInput = document.getElementById('category-name');
            const methodField = document.getElementById('method-field');

            if (mode === 'tambah') {
                formTitle.textContent = 'Tambah Kategori';
                form.action = '{{ route('category.store') }}'; // Form tambah kategori
                methodField.value = ''; // Reset method
                categoryIdInput.value = '';
                categoryNameInput.value = '';
            } else if (mode === 'edit') {
                formTitle.textContent = 'Edit Kategori';
                form.action = `{{ route('category.update', ':id') }}`.replace(':id', id); // Form update kategori
                methodField.value = 'PUT'; // Set method to PUT
                categoryIdInput.value = id;
                categoryNameInput.value = name;
            }

            formContainer.classList.remove('hidden');
        }

        function hideForm() {
            document.getElementById('form-container').classList.add('hidden');
        }
    </script>
@endpush
