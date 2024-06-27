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
            $table->string('kode_transaksi')->unique();
            $table->string('nama_penyewa');
            $table->string('alamat_penyewa');
            $table->string('noTelepon_penyewa');
            $table->date('tanggal_sewa');
            $table->date('tanggal_kembali');
            $table->decimal('harga_total', 10, 2);
            $table->enum('status_order', ['diproses', 'diterima', 'ditolak'])->default('diproses');
            $table->enum('status_sewa', ['selesai', 'sudah_lunas', 'sudah_ambil', 'dikirim'])->nullable();
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
