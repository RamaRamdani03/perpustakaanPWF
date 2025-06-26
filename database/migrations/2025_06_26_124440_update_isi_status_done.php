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
        Schema::table('peminjams', function (Blueprint $table) {
            // Hapus kolom status_pinjam jika sudah ada
            $table->dropColumn('status_pinjam');
        });

        Schema::table('peminjams', function (Blueprint $table) {
            // Tambahkan enum baru dengan 3 nilai: unaccepted, accepted, done
            $table->enum('status_pinjam', ['unaccepted', 'accepted', 'done'])->default('unaccepted')->after('batas_kembali');
        });
    }

    /**
     * Rollback migrasi.
     */
    public function down(): void
    {
        Schema::table('peminjams', function (Blueprint $table) {
            $table->dropColumn('status_pinjam');
        });

        Schema::table('peminjams', function (Blueprint $table) {
            // Kembalikan ke enum sebelumnya (atau sesuaikan kebutuhan rollback)
            $table->enum('status_pinjam', ['unaccepted', 'accepted'])->default('unaccepted')->after('batas_kembali');
        });
    }
};
