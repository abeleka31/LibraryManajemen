@php
    $layout = auth()->user()->role === 'admin' ? 'layouts.master' : 'layouts.masterStaff';
@endphp

@extends($layout)
@section('content')
    <div class="container mx-auto mt-8">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold mb-4">Pinjam Buku</h2>
            <form action="{{ route('peminjaman.store') }}" method="POST">
                @csrf
                <input type="hidden" name="book_id" value="{{ $book->id }}">
                <input type="hidden" name="mahasiswa_id" value="{{ auth()->user()->id }}">

                <!-- Tanggal Pinjam dan Pengembalian -->
                <div class="mb-4">
                    <label for="borrow_date" class="block text-sm font-medium text-gray-700">Tanggal Pinjam</label>
                    <input type="datetime-local" name="borrow_date" id="borrow_date" required value="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}" class="mt-1 block w-full p-2 border rounded-md">
                </div>

                <div class="mb-4">
                    <label for="required_date" class="block text-sm font-medium text-gray-700">Tanggal Pengembalian yang Diperlukan</label>
                    <input type="datetime-local" name="required_date" id="required_date" required value="{{ \Carbon\Carbon::now()->addDays(7)->format('Y-m-d\TH:i') }}" class="mt-1 block w-full p-2 border rounded-md">
                </div>

                <!-- Tombol Kirim -->
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 transition">Pinjam Buku</button>
                </div>
            </form>

        </div>
    </div>
@endsection
