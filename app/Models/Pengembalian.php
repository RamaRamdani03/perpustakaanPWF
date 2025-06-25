<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    public function peminjam()
    {
        return $this->belongsTo(Peminjam::class, 'id_pinjam');
    }
}
