<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Anggota;
use App\Models\Pustakawan;
use Illuminate\Support\Facades\Hash;

class AnggotaSeeder extends Seeder
{
    public function run(): void
    {
        $pustakawan = Pustakawan::first();

        Anggota::create([
            'id_pustakawan' => $pustakawan->id_pustakawan,
            'username' => 'anggota01',
            'password' => Hash::make('anggota123'),
            'nama_anggota' => 'Anggota Pertama',
            'no_tlp_anggota' => '081234567890',
            'alamat_anggota' => 'Jl. Anggota No. 1'
        ]);
    }
}
