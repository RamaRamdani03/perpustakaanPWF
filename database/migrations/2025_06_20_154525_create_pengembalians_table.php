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
            $table->id('id_kembali');
            $table->unsignedBigInteger('id_pinjam');
            $table->date('tgl_kembali');
            $table->decimal('denda', 8, 2)->default(0);
            $table->enum('status_kembali', ['selesai', 'terlambat'])->default('selesai');
            $table->timestamps();

            $table->foreign('id_pinjam')->references('id_pinjam')->on('peminjams')->onDelete('cascade');
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
