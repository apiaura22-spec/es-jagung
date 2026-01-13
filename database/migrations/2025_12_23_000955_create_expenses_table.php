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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('keterangan'); // Contoh: Gaji Karyawan, Pembelian Gula, Listrik
            $table->enum('kategori', ['gaji', 'operasional', 'bahan_baku']);
            $table->decimal('jumlah', 15, 2);
            $table->date('tanggal'); // Digunakan untuk filter laporan harian/mingguan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};