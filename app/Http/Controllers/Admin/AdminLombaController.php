<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lomba;
use Illuminate\Http\Request;

class AdminLombaController extends Controller
{
    
    public static array $tingkatOptions = [
        'Universitas' => 'Universitas',
        'Kabupaten/Kota' => 'Kabupaten/Kota',
        'Provinsi' => 'Provinsi',
        'Nasional' => 'Nasional',
        'Internasional' => 'Internasional',
    ];

    public function index()
    {
        $lombas = Lomba::orderBy('created_at', 'desc')->get();
        return view('admin.lomba.index', compact('lombas'));
    }

    public function create()
    {
        $tingkatOptions = self::$tingkatOptions;
        return view('admin.lomba.create', compact('tingkatOptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lomba' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'deadline_pendaftaran' => 'required|date',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tingkat_lomba' => 'required|string|max:255',
            'status' => 'required|in:aktif,selesai,dibatalkan',
            'max_anggota' => 'required|integer|min:0|max:20',
        ]);

        $posterPath = null;
        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('posters', 'public');
        }

        \App\Models\Lomba::create([
            'nama_lomba' => $validated['nama_lomba'],
            'deskripsi' => $validated['deskripsi'],
            'deadline_pendaftaran' => $validated['deadline_pendaftaran'],
            'poster' => $posterPath,
            'tingkat_lomba' => $validated['tingkat_lomba'],
            'status' => $validated['status'],
            'max_anggota' => $validated['max_anggota'],
        ]);

        return redirect()->route('admin.lomba.index')->with('success', 'Lomba berhasil ditambahkan.');
    }

    public function show(Lomba $lomba)
    {
        return view('admin.lomba.show', compact('lomba'));
    }

    public function edit(Lomba $lomba)
    {
        $tingkatOptions = self::$tingkatOptions;
        return view('admin.lomba.edit', compact('lomba', 'tingkatOptions'));
    }

    public function update(Request $request, Lomba $lomba)
    {
        $validated = $request->validate([
            'nama_lomba' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'deadline_pendaftaran' => 'required|date',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tingkat_lomba' => 'required|string|max:255',
            'status' => 'required|in:aktif,selesai,dibatalkan',
            'max_anggota' => 'required|integer|min:0|max:20',
        ]);

        $posterPath = $lomba->poster;
        if ($request->hasFile('poster')) {
            
            if ($lomba->poster && \Storage::disk('public')->exists($lomba->poster)) {
                \Storage::disk('public')->delete($lomba->poster);
            }
            $posterPath = $request->file('poster')->store('posters', 'public');
        }

        $lomba->update([
            'nama_lomba' => $validated['nama_lomba'],
            'deskripsi' => $validated['deskripsi'],
            'deadline_pendaftaran' => $validated['deadline_pendaftaran'],
            'poster' => $posterPath,
            'tingkat_lomba' => $validated['tingkat_lomba'],
            'status' => $validated['status'],
            'max_anggota' => $validated['max_anggota'],
        ]);

        return redirect()->route('admin.lomba.index')->with('success', 'Lomba berhasil diupdate.');
    }

    public function destroy(Lomba $lomba)
    {
        $lomba->delete();
        return redirect()->route('admin.lomba.index')->with('success', 'Lomba berhasil dihapus.');
    }
} 