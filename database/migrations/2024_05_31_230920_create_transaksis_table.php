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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->constrained('penggunas')->onDelete('cascade');
            $table->string('kode_transaksi')->unique();
            $table->date('tanggal_sewa');
            $table->date('tanggal_kembali');
            $table->decimal('harga_total', 10, 2);
            $table->enum('status', ['diproses', 'terkonfirmasi', 'selesai'])->default('diproses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
