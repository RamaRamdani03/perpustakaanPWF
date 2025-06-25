<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Pustakawan extends Authenticatable implements JWTSubject
{
    protected $table = 'pustakawans';
    protected $primaryKey = 'id_pustakawan';

    protected $fillable = [
        'username',
        'password',
        'nama_pustaka',
        'no_tlp_pustaka',
        'alamat_pustaka',
        'id_admin', // pastikan kolom ini ada di tabel
    ];

    protected $hidden = [
        'password', // untuk menyembunyikan saat serialisasi
    ];

    // JWT Implementation
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    // Laravel will automatically use this method to retrieve the password for authentication
    public function getAuthPassword()
    {
        return $this->password;
    }
}
