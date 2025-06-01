<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Mahasiswa extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'mahasiswa';
    
    protected $fillable = [
        'nim',
        'nama',
        'email',
        'password',
        'jurusan',
        'fakultas',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function prestasi()
    {
        return $this->hasMany(Prestasi::class);
    }

    public function pendaftaranLomba()
    {
        return $this->hasMany(PendaftaranLomba::class);
    }
} 