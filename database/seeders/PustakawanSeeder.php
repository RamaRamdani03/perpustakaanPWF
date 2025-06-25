<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pustakawan;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class PustakawanSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Admin::first(); // ambil admin yang sudah ada

        Pustakawan::create([
            'id_admin' => $admin->id_admin,
            'username' => 'pustaka01',
            'password' => Hash::make('pustaka123'),
            'nama_pustaka' => 'Pustakawan Utama',
            'no_tlp_pustaka' => '081234567890',
            'alamat_pustaka' => 'Jl. Perpustakaan No. 1'
        ]);
    }
}
