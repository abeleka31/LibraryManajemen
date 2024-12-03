@extends('layouts.master')

@section('title', 'Admin CRUD Operations')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css">
@endpush

@section('content')
    <div class="container mx-auto my-6">
        <h2 class="text-2xl font-semibold text-gray-700 mb-2">Admin CRUD Operations</h2>

        <p class="mb-4 text-gray-500">Admin yang sedang login: <strong>{{ Auth::user()->name }}</strong></p>

        <button onclick="showForm('tambah')" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Tambah Admin
        </button>

        <div class="flex h-[500px] space-x-4">
            <div class="w-1/2 h-full border border-gray-300 overflow-auto rounded-lg shadow-sm">
                <table id="pagination-table" class="w-full table-auto">
                    <thead class=" bg-blue-600 text-white">
                        <tr>
                            <th class="px-4 py-2 text-left">Profile</th>
                            <th class="px-4 py-2 text-left">ID</th>
                            <th class="px-4 py-2 text-left">Name</th>
                            <th class="px-4 py-2 text-left">Email</th>
                            <th class="px-4 py-2 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $admin)
                        <tr class="border-b">
                            <td class="px-4 py-2">
                                <div class="flex items-center">
                                    @if ($admin->image)
                                        <img
                                            src="{{ asset('storage/' . $admin->image) }}"
                                            alt="{{ $admin->name }}"
                                            class="w-12 h-12 rounded-full object-cover border border-gray-200 shadow-sm"
                                        >
                                    @else
                                        <img
                                            src="https://via.placeholder.com/150"
                                            alt="Gambar Tidak Tersedia"
                                            class="w-12 h-12 rounded-full object-cover border border-gray-200 shadow-sm"
                                        >
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-2">{{ $admin->id }}</td>
                            <td class="px-4 py-2">{{ $admin->name }}</td>
                            <td class="px-4 py-2">{{ $admin->email }}</td>
                            <td class="px-4 py-2">
                                <button onclick="showForm('edit', {{ $admin->id }}, '{{ $admin->name }}', '{{ $admin->email }}')" class="text-blue-500 hover:underline">Edit</button>
                                <form action="{{ route('admin.destroy', $admin->id) }}" method="POST" class="inline-block">
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

            <div class="w-1/2 h-full border border-gray-300 p-4 rounded-lg shadow-sm">
                <div id="form-container" class="hidden">
                    <h3 id="form-title" class="text-xl font-semibold mb-4">Tambah Admin</h3>
                    <form id="admin-form" method="POST" action="{{ route('admin.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" id="method-field">
                        <input type="hidden" id="admin-id" name="id">

                        <div class="mb-5">
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Upload Gambar Admin</label>
                            <input type="file" id="image" name="image" class="w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50" accept="image/*">
                        </div>

                        <div class="mb-4">
                            <label for="admin-name" class="block text-sm font-medium text-gray-700">Nama Admin</label>
                            <input type="text" id="admin-name" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>

                        <div class="mb-4">
                            <label for="admin-email" class="block text-sm font-medium text-gray-700">Email Admin</label>
                            <input type="email" id="admin-email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>

                        <div class="mb-4">
                            <label for="admin-password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" id="admin-password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
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
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.js"></script>

    <script>
        if (document.getElementById("pagination-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#pagination-table", {
                paging: true,
                perPage: 5,
                perPageSelect: [5, 10, 15, 20, 25],
                sortable: false
            });
        }

        function showForm(mode, id = null, name = '', email = '') {
            const formContainer = document.getElementById('form-container');
            const formTitle = document.getElementById('form-title');
            const form = document.getElementById('admin-form');
            const adminIdInput = document.getElementById('admin-id');
            const adminNameInput = document.getElementById('admin-name');
            const adminEmailInput = document.getElementById('admin-email');
            const adminPasswordInput = document.getElementById('admin-password');
            const methodField = document.getElementById('method-field');

            if (mode === 'tambah') {
                formTitle.textContent = 'Tambah Admin';
                form.action = '{{ route('admin.store') }}';
                methodField.value = '';
                adminIdInput.value = '';
                adminNameInput.value = '';
                adminEmailInput.value = '';
                adminPasswordInput.value = '';
            } else if (mode === 'edit') {
                formTitle.textContent = 'Edit Admin';
                form.action = `{{ route('admin.update', ':id') }}`.replace(':id', id);
                methodField.value = 'PUT';
                adminIdInput.value = id;
                adminNameInput.value = name;
                adminEmailInput.value = email;
                adminPasswordInput.value = ''; 
            }

            formContainer.classList.remove('hidden');
        }

        function hideForm() {
            document.getElementById('form-container').classList.add('hidden');
        }
    </script>
@endpush
