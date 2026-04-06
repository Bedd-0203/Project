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
        Schema::create('sdas', function (Blueprint $table) {
            $table->id();

            $table->string('title'); // Judul SDA
            $table->text('description'); // Deskripsi
            $table->string('location')->nullable(); // Lokasi SDA
            $table->string('image')->nullable(); // Gambar

            // Relasi ke kategori
            $table->foreignId('category_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sdas');
    }
};