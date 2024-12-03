@extends('layouts.masterStaff')

@section('title', 'Dashboard')

@section('content')
<div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700">
    <!-- Grid Utama -->
    <div class="grid grid-cols-2 gap-6 mb-6">
        <!-- Kartu Informasi Staff -->
        <div class="relative rounded-lg bg-white dark:bg-gray-800 shadow-lg p-6">
            <!-- Ikon Lonceng -->
            <a href="{{ route('staff.loanReturn') }}" class="absolute top-4 right-4 flex items-center justify-center w-10 h-10 bg-blue-500 text-white rounded-full shadow-md hover:bg-blue-600 transition duration-300">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a6 6 0 0 1 6 6v3.586l1.707 1.707a1 1 0 0 1-.707 1.707H3a1 1 0 0 1-.707-1.707L4 11.586V8a6 6 0 0 1 6-6Zm0 18a2 2 0 0 1-2-2h4a2 2 0 0 1-2 2Z" />
                </svg>
                @if ($countPendingReturns > 0)
                    <span class="absolute -top-2 -right-2 w-5 h-5 text-xs font-bold text-white bg-red-600 rounded-full flex items-center justify-center">
                        {{ $countPendingReturns }}
                    </span>
                @endif
            </a>

            <!-- Informasi Staff -->
            <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-4">Informasi Staff</h2>
            @if($staffs)
                <div class="space-y-2">
                    <p class="text-gray-700 dark:text-gray-300"><span class="font-semibold">ID Staff:</span> {{ $staffs->id }}</p>
                    <p class="text-gray-700 dark:text-gray-300"><span class="font-semibold">Nama:</span> {{ $staffs->user->name }}</p>
                    <p class="text-gray-700 dark:text-gray-300"><span class="font-semibold">Email:</span> {{ $staffs->user->email }}</p>
                    <p class="text-gray-700 dark:text-gray-300"><span class="font-semibold">Posisi:</span> {{ $staffs->user->role }}</p>
                    <p class="text-gray-700 dark:text-gray-300"><span class="font-semibold">Gender:</span> {{ $staffs->gender }}</p>
                    <p class="text-gray-700 dark:text-gray-300"><span class="font-semibold">No Telp:</span> {{ $staffs->no_telepon }}</p>
                    <p class="text-gray-700 dark:text-gray-300"><span class="font-semibold">Tanggal Bergabung:</span> {{ $staffs->tanggal_bergabung }}</p>
                </div>
            @else
                <p class="text-gray-500 dark:text-gray-400">Data staff tidak tersedia.</p>
            @endif
        </div>

        <!-- Placeholder Konten -->
        <div class="flex items-center justify-center h-72 rounded-lg bg-gray-50 dark:bg-gray-800 shadow-md">
            <p class="text-2xl text-gray-400 dark:text-gray-500">Konten tambahan di sini</p>
        </div>
    </div>

    <!-- Placeholder Konten Besar -->
    <div class="flex items-center justify-center h-72 rounded-lg bg-gray-50 dark:bg-gray-800 shadow-md">
        <p class="text-2xl text-gray-400 dark:text-gray-500">Konten besar bisa ditambahkan di sini</p>
    </div>
</div>
@endsection
