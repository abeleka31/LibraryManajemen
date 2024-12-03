<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained()->onDelete('cascade');// ID mahasiswa yang terkait
            $table->foreignId('loan_id')->constrained()->onDelete('cascade');
            $table->string('message'); // Pesan notifikasi
            $table->boolean('is_read')->default(false); // Status baca
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
