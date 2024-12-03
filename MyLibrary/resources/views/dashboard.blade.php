@extends('layouts.master') <!-- Pastikan nama file master sesuai dengan path -->

@section('title', 'Daftar Buku') <!-- Menentukan judul halaman -->

@section('content')
    <div class="container mx-auto my-8 p-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Daftar Buku</h2>
            <a href="{{ route('books.create') }}" class="inline-block px-6 py-2 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 mb-4 transition">Tambah Buku</a>
            <div class="flex items-center">
                <label for="filter-category" class="mr-2">Filter Berdasarkan Kategori:</label>
                <select id="filter-category" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none">
                    <option value="">Semua Kategori</option>
                    @foreach ($subCategories as $subCategory)
                        <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-center">
                <label for="filter-category" class="mr-2">Filter Berdasarkan Kategori:</label>
                <select id="filter-category" class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none">
                    <option value="">Semua subCategry</option>
                    @foreach ($subCategories as $subCategory)
                        <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="overflow-x-auto bg-white shadow rounded-lg">
                <table id="book-table" class="min-w-full text-sm text-left text-gray-500">
                    <thead class="bg-gray-100 text-gray-700 font-semibold">
                        <tr>
                            <th class="px-6 py-3">Katalog Buku</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($books as $book)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if ($book->image)
                                        <img src="{{ asset('storage/' . $book->image) }}" alt="{{ $book->name }}" class="w-24 h-36 object-cover rounded mr-4">
                                    @else
                                        <img src="https://via.placeholder.com/150" alt="Gambar Tidak Tersedia" class="w-20 h-20 object-cover rounded mr-4">
                                    @endif
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-800">{{ $book->name }}</h3>
                                        <p class="text-sm text-gray-600">Penulis: {{ $book->penulis }}</p>
                                        <p class="text-sm text-gray-600">Status: {{ $book->status }}</p>
                                        <p class="text-sm text-gray-600">Tanggal Di Tambahkan : {{ $book->created_at }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <a href="#" class="inline-block px-4 py-2 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600 transition">Lihat</a>
                                <a href="{{ route('books.edit', $book->id) }}" class="inline-block px-4 py-2 bg-yellow-500 text-white rounded-lg font-semibold hover:bg-yellow-600 transition">Edit</a>
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
<!-- Flowbite JS -->
<script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.5/dist/flowbite.min.js"></script>

<!-- Simple Datatables JS -->
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (document.getElementById("book-table")) {
            const dataTable = new simpleDatatables.DataTable("#book-table", {
                searchable: true,
                sortable: true,
            });
        }
    });
</script>
@endpush
