<?php

namespace App\Http\Controllers;

use App\Models\Lomba;
use App\Models\PendaftaranLomba;
use Illuminate\Http\Request;

class LombaController extends Controller
{
    public function index()
    {
        $lombas = Lomba::where('status', 'aktif')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('mahasiswa.lomba.index', compact('lombas'));
    }

    public function show(Lomba $lomba)
    {
        return view('mahasiswa.lomba.show', compact('lomba'));
    }

    public function daftar(Request $request, Lomba $lomba)
    {
        // Cek apakah lomba masih aktif
        if ($lomba->status !== 'aktif') {
            return redirect()->route('mahasiswa.lomba.index')
                ->with('error', 'Lomba ini sudah tidak aktif.');
        }

        // Cek apakah mahasiswa sudah mendaftar
        $pendaftaran = \App\Models\PendaftaranLomba::where('mahasiswa_id', auth()->id())
            ->where('lomba_id', $lomba->id)
            ->first();

        if ($pendaftaran) {
            return redirect()->route('mahasiswa.lomba.show', $lomba)
                ->with('error', 'Anda sudah mendaftar pada lomba ini.');
        }

        if ($request->isMethod('get')) {
            return view('mahasiswa.lomba.daftar', compact('lomba'));
        }

        // Validasi data
        $maxAnggota = $lomba->max_anggota ?? 0;
        $validated = $request->validate([
            'jurusan' => 'required|string|max:100',
            'fakultas' => 'required|string|max:100',
            'no_telp' => 'required|string|max:20',
            'jumlah_anggota' => 'nullable|integer|min:0|max:' . $maxAnggota,
        ]);

        $jumlah = (int) $request->jumlah_anggota;
        if ($jumlah > $maxAnggota) {
            return back()->withErrors(['jumlah_anggota' => 'Jumlah anggota melebihi batas maksimal.']);
        }
        for ($i = 1; $i <= $jumlah; $i++) {
            if (!$request->input("anggota{$i}_nama") || !$request->input("anggota{$i}_nim") || !$request->input("anggota{$i}_jurusan") || !$request->input("anggota{$i}_fakultas") || !$request->input("anggota{$i}_no_telp")) {
                return back()->withErrors(['anggota' => 'Semua data anggota harus diisi.'])->withInput();
            }
        }

        $data = [
            'mahasiswa_id' => auth()->id(),
            'lomba_id' => $lomba->id,
            'status' => 'pending',
            'jurusan' => $request->jurusan,
            'fakultas' => $request->fakultas,
            'no_telp' => $request->no_telp,
        ];

        for ($i = 1; $i <= 5; $i++) {
            $data["anggota{$i}_nama"] = $i <= $jumlah ? $request->input("anggota{$i}_nama") : null;
            $data["anggota{$i}_nim"] = $i <= $jumlah ? $request->input("anggota{$i}_nim") : null;
            $data["anggota{$i}_jurusan"] = $i <= $jumlah ? $request->input("anggota{$i}_jurusan") : null;
            $data["anggota{$i}_fakultas"] = $i <= $jumlah ? $request->input("anggota{$i}_fakultas") : null;
            $data["anggota{$i}_no_telp"] = $i <= $jumlah ? $request->input("anggota{$i}_no_telp") : null;
        }

        \App\Models\PendaftaranLomba::create($data);

        return redirect()->route('mahasiswa.lomba.show', $lomba)
            ->with('success', 'Pendaftaran berhasil. Silahkan tunggu konfirmasi dari admin.');
    }

    public function formDaftar(Lomba $lomba)
    {
        // Cek apakah lomba masih aktif
        if ($lomba->status !== 'aktif') {
            return redirect()->route('mahasiswa.lomba.index')
                ->with('error', 'Lomba ini sudah tidak aktif.');
        }
        // Cek apakah mahasiswa sudah mendaftar
        $pendaftaran = \App\Models\PendaftaranLomba::where('mahasiswa_id', auth()->id())
            ->where('lomba_id', $lomba->id)
            ->first();
        if ($pendaftaran) {
            return redirect()->route('mahasiswa.lomba.show', $lomba)
                ->with('error', 'Anda sudah mendaftar pada lomba ini.');
        }
        return view('mahasiswa.lomba.daftar', compact('lomba'));
    }
} 