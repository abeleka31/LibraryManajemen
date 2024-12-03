@extends('layouts.myLibraryMaster')

@section('content')
<div class="container mx-auto mt-8 px-4 pt-20" style="height: 90vh;">
    <div class="bg-white p-6 pb-36rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 ease-in-out " style="height: 90vh">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800 dark:text-white">Daftar Peminjaman Buku Saya</h2>
        <!-- Flowbite DataTable -->
        <div class="overflow-x-auto relative shadow-md sm:rounded-lg ">
            <table id="loan-table" class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
                <thead class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-100">
                    <tr>
                        <th class="px-4 py-2">Nama Buku</th>
                        <th class="px-4 py-2">Order Borrow</th>
                        <th class="px-4 py-2">Required Date</th>
                        <th class="px-4 py-2">Return Date</th>
                        <th class="px-4 py-2">Sisa Waktu</th>
                        <th class="px-4 py-2">Denda</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Aksi</th>
                        <th class="px-4 py-2">Perpanjang</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($loans as $loan)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-300">
                        <td class="px-4 py-2">{{ $loan->book->name }}</td>
                        <td class="px-4 py-2">{{ $loan->borrow_date }}</td>
                        <td class="px-4 py-2">{{ $loan->required_date }}</td>
                        <td class="px-4 py-2">{{ $loan->return_date ?? 'belum di kembalikan' }}</td>
                        <td class="px-4 py-2" id="time-status-{{ $loan->id }}"></td>
                        <td class="px-4 py-2" id="fine-{{ $loan->id }}">{{ $loan->denda }}</td>
                        <td class="px-4 py-2">
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
                        <td class="px-4 py-2">
                            @if($loan->status == 'dalam pinjaman')
                            <button onclick="toggleModal('return-book-modal-{{ $loan->id }}')" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 transition-all duration-300 ease-in-out">
                                Kembalikan
                            </button>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            @if($loan->status == 'dalam pinjaman')
                                <!-- Tombol Perpanjang -->
                                <button onclick="toggleExtendModal('extend-book-modal-{{ $loan->id }}')" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-700 transition-all duration-300 ease-in-out">
                                    Perpanjang
                                </button>
                            @endif
                        </td>
                    </tr>
                    <script>
                        // JavaScript untuk update fine dan time status
                        const loan{{ $loan->id }} = {
                            requiredDate: new Date("{{ $loan->required_date }}"),
                            returnDate: @if($loan->return_date) new Date("{{ $loan->return_date }}") @else null @endif,
                        };

                        function calculateFine(loan) {
                            const finePerSecond = 0.5; // Denda per detik
                            let fine = 0;

                            if (loan.returnDate) {
                                const diff = loan.returnDate - loan.requiredDate;
                                if (diff > 0) {
                                    const diffInSeconds = Math.floor(diff / 1000);
                                    fine = diffInSeconds * finePerSecond;
                                }
                            } else {
                                const diff = new Date() - loan.requiredDate;
                                if (diff > 0) {
                                    const diffInSeconds = Math.floor(diff / 1000);
                                    fine = diffInSeconds * finePerSecond;
                                }
                            }
                            return fine;
                        }

                        function updateTimeStatusAndFine{{ $loan->id }}() {
                            const now = new Date();
                            const timeStatusElement = document.getElementById('time-status-{{ $loan->id }}');
                            const fineElement = document.getElementById('fine-{{ $loan->id }}');
                            const fineInput = document.getElementById('fine-input-{{ $loan->id }}');
                            let message = '';
                            let textColor = '';

                            if ("{{ $loan->status }}" === "dalam pinjaman" ) {
                                const diff = loan{{ $loan->id }}.requiredDate - now;

                                if (diff >= 0) {
                                    message = `Sisa Waktu: ${formatTime(diff)}`;
                                    textColor = 'text-green-500';
                                    fineElement.innerHTML = 'Tidak Ada Denda';
                                } else {
                                    message = `Terlambat: ${formatTime(-diff)}`;
                                    textColor = 'text-red-500';
                                    const calculatedFine = calculateFine(loan{{ $loan->id }});
                                    fineElement.innerHTML = `Rp ${calculatedFine.toLocaleString()}`;
                                    fineInput.value = calculatedFine;  // Update fine in the hidden input
                                    sendFineUpdate({{ $loan->id }}); // Kirim denda menggunakan AJAX
                                }
                            }

                            timeStatusElement.innerHTML = `<span class="${textColor}">${message}</span>`;
                        }

                        function formatTime(milliseconds) {
                            const totalSeconds = Math.floor(milliseconds / 1000);
                            const hours = Math.floor(totalSeconds / 3600);
                            const minutes = Math.floor((totalSeconds % 3600) / 60);
                            const seconds = totalSeconds % 60;
                            return `${hours} Jam ${minutes} Menit ${seconds} Detik`;
                        }

                        function sendFineUpdate(loanId) {
                            const form = document.getElementById('update-fine-form-' + loanId);
                            const formData = new FormData(form);

                            fetch(form.action, {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    console.log('Denda berhasil diperbarui');
                                } else {
                                    console.log('Gagal mengupdate denda');
                                }
                            })
                            .catch(error => {
                                console.log('Error:', error);
                            });
                        }

                        if ("{{ $loan->status }}" === "dalam pinjaman") {
                            setInterval(updateTimeStatusAndFine{{ $loan->id }}, 1000);
                            updateTimeStatusAndFine{{ $loan->id }}();
                        }
                    </script>

                    <!-- Form untuk update denda otomatis -->
                    <form id="update-fine-form-{{ $loan->id }}" action="{{ route('loan.updateFine', $loan->id) }}" method="POST" class="hidden">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="fine" id="fine-input-{{ $loan->id }}" value="{{ $loan->denda }}">
                    </form>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal for return with review and rating -->
@foreach ($loans as $loan)
    <div id="return-book-modal-{{ $loan->id }}" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 justify-center items-center z-50" aria-hidden="true">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl w-full max-w-md">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Pengembalian Buku</h2>
            <!-- Modal content for review -->
            @if ($loan->status !== 'dikembalikan')
                @if (!$loan->review)
                    <form action="{{ route('loan.returnBook', $loan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Rating and Review -->
                        <div class="mb-4">
                            <label for="rating-{{ $loan->id }}" class="block text-sm text-gray-700 dark:text-gray-300">Rating</label>
                            <select name="rating" id="rating-{{ $loan->id }}" class="w-full p-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:outline-none">
                                <option value="1">1 - Buruk</option>
                                <option value="2">2 - Cukup</option>
                                <option value="3">3 - Baik</option>
                                <option value="4">4 - Sangat Baik</option>
                                <option value="5">5 - Luar Biasa</option>
                            </select>
                        </div>

                        <!-- Ulasan -->
                        <div class="mb-4">
                            <label for="review-{{ $loan->id }}" class="block text-sm text-gray-700 dark:text-gray-300">Ulasan</label>
                            <textarea name="comment" id="review-{{ $loan->id }}" rows="4" class="w-full p-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:outline-none"></textarea>
                        </div>

                        <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-700 transition-all duration-300 ease-in-out">
                            Kembalikan dan Kirim Ulasan
                        </button>
                    </form>
                @else
                    <p class="text-gray-600 dark:text-gray-300">Anda sudah memberikan ulasan untuk buku ini.</p>
                @endif
            @else
                <p class="text-gray-600 dark:text-gray-300">Buku ini sudah dikembalikan. Anda tidak dapat memberikan ulasan lagi.</p>
            @endif
            <button onclick="toggleModal('return-book-modal-{{ $loan->id }}')" class="mt-4 w-full bg-gray-400 text-white py-2 rounded-lg hover:bg-gray-500 transition-all duration-300 ease-in-out">
                Batal
            </button>
        </div>
    </div>
@endforeach
<!-- Modal untuk perpanjangan masa peminjaman -->
@foreach ($loans as $loan)
    <div id="extend-book-modal-{{ $loan->id }}" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 justify-center items-center z-50" aria-hidden="true">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-xl w-full max-w-md">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Perpanjang Masa Peminjaman Buku</h2>
            <!-- Form perpanjangan -->
            <form action="{{ route('loan.extend', $loan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="extend-date-{{ $loan->id }}" class="block text-sm text-gray-700 dark:text-gray-300">Tanggal Perpanjangan</label>
                    <input type="date" name="extend_date" id="extend-date-{{ $loan->id }}" class="w-full p-2 bg-gray-100 dark:bg-gray-700 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:outline-none" required>
                </div>

                <button type="submit" class="w-full bg-yellow-500 text-white py-2 rounded-lg hover:bg-yellow-700 transition-all duration-300 ease-in-out">
                    Perpanjang
                </button>
            </form>

            <button onclick="toggleModal('extend-book-modal-{{ $loan->id }}')" class="mt-4 w-full bg-gray-400 text-white py-2 rounded-lg hover:bg-gray-500 transition-all duration-300 ease-in-out">
                Batal
            </button>
        </div>
    </div>
@endforeach

<script>
    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }
    function toggleExtendModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal.classList.contains('hidden')) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    } else {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
}

</script>
@endsection

