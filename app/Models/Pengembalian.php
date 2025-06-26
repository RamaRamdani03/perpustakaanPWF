<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $fillable = [
        'id_pinjam',
        'tgl_kembali',
        'denda',
        'status_kembali'
    ];

    public function peminjam()
    {
        return $this->belongsTo(Peminjam::class, 'id_pinjam');
    }
}
