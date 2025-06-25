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
        Schema::create('anggotas', function (Blueprint $table) {
            $table->id('id_anggota');
            $table->unsignedBigInteger('id_pustakawan');
            $table->string('nama_anggota');
            $table->string('username')->unique();
            $table->string('no_tlp_anggota');
            $table->string('password');
            $table->text('alamat_anggota');
            $table->timestamps();

            $table->foreign('id_pustakawan')->references('id_pustakawan')->on('pustakawans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggotas');
    }
};
