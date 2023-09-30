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
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('nama_siswa');
            $table->string('nisn_siswa');
            $table->string('nis_siswa');
            $table->string('tempat_lahir_siswa');
            $table->date('tanggal_lahir_siswa');
            $table->string('photo')->default('siswa.jpg');
            $table->enum('status_pemilihan_siswa', ['Belum Memilih', 'Sudah Memilih'])->default('Belum Memilih');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
