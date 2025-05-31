<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lomba extends Model
{
    protected $table = 'lomba';
    
    protected $fillable = [
        'nama_lomba',
        'deskripsi',
        'deadline_pendaftaran',
        'link_pendaftaran',
        'poster',
        'tingkat_lomba',
        'status',
        'max_anggota',
    ];

    protected $casts = [
        'deadline_pendaftaran' => 'date',
    ];

    public function pendaftaranLomba()
    {
        return $this->hasMany(PendaftaranLomba::class);
    }
} 