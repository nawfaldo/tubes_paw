<?php

namespace App\Http\Controllers;

use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrestasiController extends Controller
{
    public function index()
    {
        $prestasi = Prestasi::where('mahasiswa_id', auth()->guard('mahasiswa')->id())
            ->latest()
            ->get();
        return view('mahasiswa.prestasi.index', compact('prestasi'));
    }

    public function create()
    {
        return view('mahasiswa.prestasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lomba' => 'required',
            'juara' => 'required',
            'tingkat_lomba' => 'required',
            'bukti' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable',
        ]);

        $bukti = $request->file('bukti');
        $buktiPath = $bukti->store('bukti_prestasi', 'public');

        Prestasi::create([
            'mahasiswa_id' => auth()->guard('mahasiswa')->id(),
            'nama_lomba' => $request->nama_lomba,
            'juara' => $request->juara,
            'tingkat_lomba' => $request->tingkat_lomba,
            'bukti' => $buktiPath,
            'tanggal' => $request->tanggal,
            'deskripsi' => $request->deskripsi,
            'status' => 'pending'
        ]);

        return redirect()->route('mahasiswa.prestasi.index')
            ->with('success', 'Prestasi berhasil ditambahkan');
    }

    public function show(Prestasi $prestasi)
    {
        if ($prestasi->mahasiswa_id !== auth()->guard('mahasiswa')->id()) {
            abort(403);
        }
        return view('mahasiswa.prestasi.show', compact('prestasi'));
    }

    public function edit(Prestasi $prestasi)
    {
        if ($prestasi->mahasiswa_id !== auth()->guard('mahasiswa')->id()) {
            abort(403);
        }
        return view('mahasiswa.prestasi.edit', compact('prestasi'));
    }

    public function update(Request $request, Prestasi $prestasi)
    {
        if ($prestasi->mahasiswa_id !== auth()->guard('mahasiswa')->id()) {
            abort(403);
        }

        $request->validate([
            'nama_lomba' => 'required',
            'juara' => 'required',
            'tingkat_lomba' => 'required',
            'bukti' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable',
        ]);

        $data = $request->except('bukti');
        
        if ($request->hasFile('bukti')) {
            Storage::disk('public')->delete($prestasi->bukti);
            $data['bukti'] = $request->file('bukti')->store('bukti_prestasi', 'public');
        }

        $prestasi->update($data);

        return redirect()->route('mahasiswa.prestasi.index')
            ->with('success', 'Prestasi berhasil diperbarui');
    }

    public function destroy(Prestasi $prestasi)
    {
        if ($prestasi->mahasiswa_id !== auth()->guard('mahasiswa')->id()) {
            abort(403);
        }

        Storage::disk('public')->delete($prestasi->bukti);
        $prestasi->delete();

        return redirect()->route('mahasiswa.prestasi.index')
            ->with('success', 'Prestasi berhasil dihapus');
    }
} 