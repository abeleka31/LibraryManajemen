<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->onDelete('cascade'); // Foreign key ke mahasiswa
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');          // Foreign key ke books
            $table->foreignId('staff_borrow_id')->nullable()->constrained('staff')->onDelete('set null'); // Pegawai yang menyetujui peminjaman
            $table->foreignId('staff_return_id')->nullable()->constrained('staff')->onDelete('set null'); // Pegawai yang menyetujui pengembalian
            $table->decimal('denda', 10, 2)->default(0);
            $table->enum('status', ['pengajuan', 'dalam pinjaman', 'pengajuan pengembalian', 'dikembalikan'])->default('pengajuan');
            $table->date('borrow_date')->nullable();
            $table->date('required_date');
            $table->date('return_date')->nullable();
            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('moncongloes');
    }
};
