<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use App\Models\Lomba;
use App\Models\PendaftaranLomba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminMahasiswaController extends Controller
{
    public function index()
    {
        $pendaftaran = PendaftaranLomba::with(['mahasiswa', 'lomba'])->orderBy('created_at', 'desc')->get();
        return view('admin.mahasiswa.index', compact('pendaftaran'));
    }

    public function create()
    {
        $mahasiswas = Mahasiswa::orderBy('nim')->get();
        $lombas = Lomba::where('status', 'aktif')->orderBy('nama_lomba')->get();
        return view('admin.mahasiswa.create', compact('mahasiswas', 'lombas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswa,id',
            'lomba_id' => 'required|exists:lomba,id',
            'jurusan' => 'required',
            'fakultas' => 'required',
            'no_telp' => 'required',
        ]);

        $data = $request->all();
        $data['status'] = 'pending';

        PendaftaranLomba::create($data);

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Pendaftaran lomba berhasil ditambahkan');
    }

    public function show(Mahasiswa $mahasiswa)
    {
        return view('admin.mahasiswa.show', compact('mahasiswa'));
    }

    public function edit($id)
    {
        $pendaftaran = PendaftaranLomba::findOrFail($id);
        $mahasiswas = Mahasiswa::orderBy('nim')->get();
        $lombas = Lomba::orderBy('nama_lomba')->get();
        return view('admin.mahasiswa.edit', compact('pendaftaran', 'mahasiswas', 'lombas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswa,id',
            'lomba_id' => 'required|exists:lomba,id',
            'jurusan' => 'required',
            'fakultas' => 'required',
            'no_telp' => 'required',
            'status' => 'required|in:pending,diterima,ditolak',
        ]);

        $pendaftaran = PendaftaranLomba::findOrFail($id);
        $pendaftaran->update($request->all());

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Data pendaftaran lomba berhasil diperbarui');
    }

    public function destroy($id)
    {
        $pendaftaran = PendaftaranLomba::findOrFail($id);
        $pendaftaran->delete();

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Data pendaftaran lomba berhasil dihapus');
    }

    public function showPendaftaran($id)
    {
        $pendaftaran = PendaftaranLomba::with(['mahasiswa', 'lomba'])->findOrFail($id);
        return view('admin.mahasiswa.pendaftaran_show', compact('pendaftaran'));
    }

    public function storePendaftaran(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswa,id',
            'lomba_id' => 'required|exists:lomba,id',
            'jurusan' => 'required',
            'fakultas' => 'required',
            'no_telp' => 'required',
        ]);

        $data = $request->all();
        $data['status'] = 'pending';

        PendaftaranLomba::create($data);

        return redirect()->route('admin.mahasiswa.index')
            ->with('success', 'Pendaftaran lomba berhasil ditambahkan');
    }
} 