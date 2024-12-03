@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
    <div class="dashboard px-4 sm:px-8 py-4" style="width: 100%; height: 60px; font-size: 30px;">
        <h1>Dashboard</h1>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 p-4 sm:pl-8 sm:pr-8">
        <a href="#" class="block w-full h-20 p-4 bg-white border border-gray-200 rounded-lg shadow-lg transform transition-transform hover:-translate-y-2 hover:bg-gray-100">
            <div class="flex justify-between items-center h-full">
                <div>
                    <h5 class="text-xl font-bold tracking-tight text-gray-900">New book +</h5>
                    <p class="text-sm font-normal text-gray-700">{{ $bookCount }} books in database</p>
                </div>
                <h1 class="text-5xl">📚</h1>
            </div>
        </a>

        <a href="{{ route('staff.create') }}" class="block w-full h-20 p-4 bg-white border border-gray-200 rounded-lg shadow-lg transform transition-transform hover:-translate-y-2 hover:bg-gray-100">
            <div class="flex justify-between items-center h-full">
                <div>
                    <h5 class="text-xl font-bold tracking-tight text-gray-900">Add Staff +</h5>
                    <p class="text-sm font-normal text-gray-700">{{ $staffCount }} Staff in database</p>
                </div>
                <h1 class="text-5xl">👥</h1>
            </div>
        </a>

        <a href="{{ route('mahasiswa.index') }}" class="block w-full h-20 p-4 bg-white border border-gray-200 rounded-lg shadow-lg transform transition-transform hover:-translate-y-2 hover:bg-gray-100">
            <div class="flex justify-between items-center h-full">
                <div>
                    <h5 class="text-xl font-bold tracking-tight text-gray-900">Student +</h5>
                    <p class="text-sm font-normal text-gray-700">{{ $mahasiswaCount }} student in database</p>
                </div>
                <h1 class="text-5xl">📚</h1>
            </div>
        </a>
    </div>

    <h1 class="px-4 py-2 text-2xl font-semibold">Daftar Pinjaman</h1>
    <div class="h-72 w-full bg-white overflow-x-auto rounded-lg shadow-lg p-4">
        <table class="min-w-full table-auto border-collapse border border-gray-300">
            <thead class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-100">
                <tr>
                    <th class="px-4 py-2 border">Nama Peminjam</th>
                    <th class="px-4 py-2 border">Email</th>
                    <th class="px-4 py-2 border">Nama Buku</th>
                    <th class="px-4 py-2 border">Order Borrow</th>
                    <th class="px-4 py-2 border">Required Date</th>
                    <th class="px-4 py-2 border">Return Date</th>
                    <th class="px-4 py-2 border">Sisa Waktu</th>
                    <th class="px-4 py-2 border">Denda</th>
                    <th class="px-4 py-2 border">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($loanse as $loan)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-300">
                        <td class="px-4 py-2 border">{{ $loan->mahasiswa->user->name }}</td>
                        <td class="px-4 py-2 border">{{ $loan->mahasiswa->user->email }}</td>
                        <td class="px-4 py-2 border">{{ $loan->book->name }}</td>
                        <td class="px-4 py-2 border">{{ $loan->borrow_date }}</td>
                        <td class="px-4 py-2 border">{{ $loan->required_date }}</td>
                        <td class="px-4 py-2 border">{{ $loan->return_date ?? 'Belum dikembalikan' }}</td>
                        <td class="px-4 py-2 border" id="time-status-{{ $loan->id }}"></td>
                        <td class="px-4 py-2 border">{{ $loan->denda }}</td>
                        <td class="px-4 py-2 border">
                            @switch($loan->status)
                                @case('pengajuan')
                                    <span class="text-yellow-500">Menunggu Persetujuan</span>
                                    @break
                                @case('dalam pinjaman')
                                    <span class="text-green-500">Dalam Pinjaman</span>
                                    @break
                                @case('dikembalikan')
                                    <span class="text-blue-500">Dikembalikan</span>
                                    @break
                                @case('pengajuan pengembalian')
                                    <span class="text-blue-500">Pengajuan Pengembalian</span>
                                    @break
                            @endswitch
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection




