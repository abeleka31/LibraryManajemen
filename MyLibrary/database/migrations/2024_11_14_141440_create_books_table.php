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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('penulis');
            $table->string('penerbit');
            $table->year('tahunTerbit');
            $table->enum('status', ['tersedia', 'tidak tersedia'])->default('tersedia');
            $table->integer('ISBN');
            $table->text('description');
            $table->foreignId('subcategory_id')->constrained('sub_categories')->onDelete('cascade');
            $table->integer('jumlahStock');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
