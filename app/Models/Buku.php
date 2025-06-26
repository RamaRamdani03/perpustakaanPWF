<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'bukus';
    protected $primaryKey = 'id_buku';

    protected $fillable = [
        'judul_buku',
        'id_kategori',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'cover',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriBuku::class, 'id_kategori');
    }

    public function peminjams()
    {
        return $this->hasMany(Peminjam::class, 'id_buku');
    }
}
