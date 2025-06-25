<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Pustakawan extends Authenticatable implements JWTSubject
{
    protected $table = 'pustakawans';
    protected $primaryKey = 'id_pustakawan';

    protected $fillable = ['usr_pustaka', 'pw_pustaka', 'nama_pustaka', 'no_tlp_pustaka', 'alamat_pustaka'];
    protected $hidden = ['pw_pustaka'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    public function getAuthPassword()
    {
        return $this->pw_pustaka;
    }
}
