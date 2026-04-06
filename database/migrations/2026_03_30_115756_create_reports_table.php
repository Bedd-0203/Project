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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();

            // Relasi ke user (masyarakat)
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('title'); // Judul laporan
            $table->text('description'); // Isi laporan

            $table->string('image')->nullable(); // Bukti foto

            // Status laporan
            $table->enum('status', ['pending', 'diproses', 'selesai'])
                  ->default('pending');

            // Respon dari petugas
            $table->text('response')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};