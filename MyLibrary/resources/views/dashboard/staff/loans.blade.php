@extends('layouts.masterStaff')

@section('content')
    <div class="container mx-auto mt-8">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold mb-4">Daftar Peminjaman Buku</h2>
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Nama Mahasiswa</th>
                        <th class="px-4 py-2">Nama Buku</th>
                        <th class="px-4 py-2">Tanggal pengembalian(request)</th>
                        <th class="px-4 py-2">denda</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($loans as $loan)
                        <tr>
                            <td class="px-4 py-2">{{ $loan->mahasiswa->user->name }}</td>
                            <td class="px-4 py-2">{{ $loan->book->name }}</td>
                            <td class="px-4 py-2">{{ $loan->required_date}}</td>
                            <td class="px-4 py-2">{{ $loan->denda}}</td>
                            <td class="px-4 py-2">
                                @if($loan->status === 'pengajuan')
                                    <form action="{{ route('loan.approveBorrow', $loan->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="staff_id" value="{{ Auth::user()->staff->id }}">
                                        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg">Setujui</button>
                                    </form>
                                    <form action="{{ route('loan.ApproveReturn', $loan->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg">Tolak</button>
                                    </form>
                                @else
                                    <span class="text-gray-500">Proses selesai</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
