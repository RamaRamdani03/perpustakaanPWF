<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjam extends Model
{
    // Jika nama primary key-nya bukan "id", sebutkan
    protected $primaryKey = 'id_pinjam';

    // Agar Laravel tidak menambahkan 's' di akhir nama tabel (misalnya `peminjams`)
    protected $table = 'peminjams';

    // Jika ingin bisa mass-assignment
    protected $fillable = [
        'id_anggota',
        'id_buku',
        'tgl_pinjam',
        'batas_kembali',
        'status_pinjam',
    ];

    // Relasi ke anggota
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota');
    }

    // Relasi ke buku
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku');
    }

    // Relasi ke pengembalian (jika ada)
    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'id_pinjam');
    }
}
