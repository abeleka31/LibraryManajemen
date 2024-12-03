@extends('layouts.master')

@section('title', 'Daftar Mahasiswa')

@section('content')
    <div class="container mx-auto my-8 p-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Daftar Mahasiswa</h2>

            <a href="{{ route('mahasiswa.create') }}" class="mb-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Tambah Mahasiswa
            </a>

            <div class="overflow-x-auto mt-4">
                <table id="search-table" class="min-w-full bg-white text-sm text-left text-gray-500 shadow rounded-lg" style="table-layout: auto;">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">Foto</th>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">NIM</th>
                            <th class="px-4 py-2">Tanggal Lahir</th>
                            <th class="px-4 py-2">Jenis Kelamin</th>
                            <th class="px-4 py-2">Program Studi</th>
                            <th class="px-4 py-2">No Telepon</th>
                            <th class="px-4 py-2">Tanggal Bergabung</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach ($mahasiswa as $mhs)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2">
                                    <div class="flex items-center justify-center w-12 h-12 rounded-full overflow-hidden border border-gray-200 shadow-sm">
                                        @if ($mhs->user->image)
                                            <img src="{{ asset('storage/' . $mhs->user->image) }}" alt="{{ $mhs->user->name }}" class="w-full h-full object-cover">
                                        @else
                                            <img src="https://via.placeholder.com/150" alt="Gambar Tidak Tersedia" class="w-full h-full object-cover">
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-2" style="white-space: nowrap;">{{ $mhs->user->name }}</td>
                                <td class="px-4 py-2" style="white-space: nowrap;">{{ $mhs->user->email }}</td>
                                <td class="px-4 py-2" style="white-space: nowrap;">{{ $mhs->nim }}</td>
                                <td class="px-4 py-2" style="white-space: nowrap;">{{ $mhs->tanggal_lahir }}</td>
                                <td class="px-4 py-2" style="white-space: nowrap;">{{ $mhs->jenis_kelamin }}</td>
                                <td class="px-4 py-2" style="white-space: nowrap;">{{ $mhs->program_studi }}</td>
                                <td class="px-4 py-2" style="white-space: nowrap;">{{ $mhs->telepon }}</td>
                                <td class="px-4 py-2" style="white-space: nowrap;">{{ $mhs->created_at->format('d M Y') }}</td>
                                <td class="px-4 py-2 space-x-2">
                                    <a href="{{route('mahasiswa.edit', $mhs->user->id)}}" class="text-yellow-500 hover:text-yellow-600">Edit</a>
                                    <form action="{{route('mahasiswa.destroy', $mhs->user->id)}}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-600" onclick="return confirm('Yakin ingin menghapus?')">
                                            Hapus
                                        </button>
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
    <!-- Simple DataTables Script -->
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"></script>

    <script>
        if (document.getElementById("search-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#search-table", {
                searchable: true,
                sortable: false
            });
        }
    </script>
@endpush
