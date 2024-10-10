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
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->id('id_pengembalian');
            $table->string('deskripsi');
            $table->date('tggl_kembali');
            $table->binary('bukti')->nullable();
            $table->unsignedBigInteger('petugas_id');
            $table->unsignedBigInteger('id_peminjaman');
            $table->timestamps();

            $table->foreign(columns: 'petugas_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign(columns: 'id_peminjaman')->references('id_peminjaman')->on('peminjamans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};
