<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    public function kategori()
    {
        return $this->belongsTo(KategoriBuku::class, 'id_kategori');
    }

    public function peminjams()
    {
        return $this->hasMany(Peminjam::class, 'id_buku');
    }
}
