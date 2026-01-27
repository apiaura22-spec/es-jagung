<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('orders', function (Blueprint $table) {
        // Kita hapus 'after', supaya dia otomatis diletakkan di akhir kolom yang ada
        $table->string('metode_pembayaran')->default('midtrans');
    });
}

public function down()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn('metode_pembayaran');
    });
}
};
