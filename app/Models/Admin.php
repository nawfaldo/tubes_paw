<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'admin';
    
    protected $fillable = [
        'nip',
        'nama',
        'email',
        'password',
        'jabatan',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
} 