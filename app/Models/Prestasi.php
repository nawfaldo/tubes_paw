<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    protected $table = 'prestasi';
    
    protected $fillable = [
        'mahasiswa_id',
        'nama_lomba',
        'juara',
        'tingkat_lomba',
        'bukti',
        'tanggal',
        'deskripsi',
        'status',
        'catatan_admin',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
} 