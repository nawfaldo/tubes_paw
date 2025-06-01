<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranLomba extends Model
{
    protected $table = 'pendaftaran_lomba';
    
    protected $fillable = [
        'mahasiswa_id',
        'lomba_id',
        'status',
        'catatan_admin',
        'no_telp',
        'jurusan',
        'fakultas',
        'anggota1_nama', 'anggota1_nim', 'anggota1_jurusan', 'anggota1_fakultas', 'anggota1_no_telp',
        'anggota2_nama', 'anggota2_nim', 'anggota2_jurusan', 'anggota2_fakultas', 'anggota2_no_telp',
        'anggota3_nama', 'anggota3_nim', 'anggota3_jurusan', 'anggota3_fakultas', 'anggota3_no_telp',
        'anggota4_nama', 'anggota4_nim', 'anggota4_jurusan', 'anggota4_fakultas', 'anggota4_no_telp',
        'anggota5_nama', 'anggota5_nim', 'anggota5_jurusan', 'anggota5_fakultas', 'anggota5_no_telp',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function lomba()
    {
        return $this->belongsTo(Lomba::class);
    }
} 