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
        Schema::create('hasil_pemilihans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pemilihan_id');
            $table->unsignedBigInteger('kandidat_id');
            $table->bigInteger('hasil_pemilihan')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_pemilihans');
    }
};
