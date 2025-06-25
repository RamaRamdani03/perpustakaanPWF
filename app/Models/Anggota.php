<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Anggota extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = 'anggotas';
    protected $primaryKey = 'id_anggota';

    protected $fillable = [
        'id_pustakawan',
        'nama_anggota',
        'username',
        'password',
        'no_tlp_anggota',
        'alamat_anggota',
    ];

    protected $hidden = ['password'];

    public function pustakawan()
    {
        return $this->belongsTo(Pustakawan::class, 'id_pustakawan');
    }

    public function peminjams()
    {
        return $this->hasMany(Peminjam::class, 'id_anggota');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
