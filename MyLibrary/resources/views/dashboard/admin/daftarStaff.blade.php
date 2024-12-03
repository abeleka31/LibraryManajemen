@extends('layouts.master')

@section('title', 'Daftar Staff')

@section('content')
    <div class="container mx-auto my-8 p-6">
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Daftar Staff</h2>
            <a href="{{ route('staff.create') }}" class="btn-add mb-4 inline-block px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">Tambah Staff</a>

            <div class="overflow-x-auto bg-white shadow rounded-lg">
                <table id="search-table" class="min-w-full text-sm text-left text-gray-500">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left">Nama</th>
                            <th class="px-6 py-3 text-left">Email</th>
                            <th class="px-6 py-3 text-left">Jenis Kelamin</th>
                            <th class="px-6 py-3 text-left">No Telepon</th>
                            <th class="px-6 py-3 text-left">Tanggal Bergabung</th>
                            <th class="px-6 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach ($staffs as $staff)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4">{{ $staff->user->name }}</td>
                            <td class="px-6 py-4">{{ $staff->user->email }}</td>
                            <td class="px-6 py-4">{{ $staff->gender }}</td>
                            <td class="px-6 py-4">{{ $staff->no_telepon }}</td>
                            <td class="px-6 py-4">{{ $staff->tanggal_bergabung }}</td>
                            <td class="px-6 py-4 space-x-2">
                                <a href="{{ route('staff.edit', $staff->id) }}" class="text-yellow-500 hover:text-yellow-600">Edit</a>
                                <form action="{{ route('staff.destroy', $staff->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Flowbite JS -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.js"></script>

    <!-- Initialize Simple Datatables -->
    <script>
        if (document.getElementById("search-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#search-table", {
                searchable: true,
                sortable: true,
            });
        }
    </script>
@endsection
