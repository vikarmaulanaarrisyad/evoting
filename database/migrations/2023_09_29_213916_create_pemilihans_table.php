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
        Schema::create('pemilihans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_mulai_pemilihan');
            $table->date('tanggal_selesai_pemilihan');
            $table->text('deskripsi_pemilihan');
            $table->enum('status_pemilihan', ['Belum Dimulai', 'Sedang Berlangsung', 'Selesai'])->default('Belum Dimulai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemilihans');
    }
};
