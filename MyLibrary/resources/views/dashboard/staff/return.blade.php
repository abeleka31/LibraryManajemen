@extends('layouts.masterstaff')

@section('content')
    <div class="container mx-auto mt-8">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold mb-4">Pengembalian Buku</h2>
            <table class="table-auto w-full">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Nama Buku</th>
                        <th class="px-4 py-2">Tanggal Pengembalian</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($loans as $loan)
                        @if($loan->status == 'pengajuan pengembalian' || $loan->status == 'pengajuan')
                            <tr>
                                <td class="px-4 py-2">{{ $loan->book->name }}</td>
                                <td class="px-4 py-2">{{ $loan->return_date }}</td>
                                <td class="px-4 py-2">{{ $loan->status }}</td>
                                <td>
                                    @if($loan->status === 'pengajuan pengembalian')
                                        <form action="{{ route('loan.ApproveReturn', $loan->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="staff_id" value="{{ Auth::user()->staff->id }}">
                                            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg">Setujui Pengembalian</button>
                                        </form>
                                    @elseif($loan->status === 'pengajuan')
                                        <form action="{{ route('loan.approveBorrow', $loan->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="staff_id" value="{{ Auth::user()->staff->id }}">
                                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Setujui Peminjaman</button>
                                        </form>
                                    @else
                                        <span class="text-gray-500">Proses selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
