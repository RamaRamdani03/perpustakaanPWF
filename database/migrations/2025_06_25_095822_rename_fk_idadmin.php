<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pustakawans', function (Blueprint $table) {
            // Pastikan kolom id_admin sudah ada, misalnya:
            // $table->unsignedBigInteger('id_admin')->change();

            // Hapus dulu foreign key yang ada jika ada
            $table->dropForeign(['id_admin']); 

            // Buat foreign key ke admins.id_admin
            $table->foreign('id_admin')->references('id_admin')->on('admins')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('pustakawans', function (Blueprint $table) {
            $table->dropForeign(['id_admin']);
            // Jika perlu, buat foreign key lama kembali, misal:
            // $table->foreign('id_admin')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
