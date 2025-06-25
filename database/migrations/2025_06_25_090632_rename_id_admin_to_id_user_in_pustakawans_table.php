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
        Schema::table('pustakawans', function (Blueprint $table) {
            // Hapus foreign key lama
            $table->dropForeign(['id_admin']);

            // Ubah relasinya ke tabel users.id
            $table->foreign('id_admin')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pustakawans', function (Blueprint $table) {
            // Hapus foreign key ke users.id
            $table->dropForeign(['id_admin']);

            // Kembalikan ke foreign key sebelumnya (jika perlu, sesuaikan nama kolom dan tabel)
            $table->foreign('id_admin')->references('id_admin')->on('admins')->onDelete('cascade');
        });
    }
};
