<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PrestasiController extends Controller
{
    public function index(Request $request)
    {
        $prestasi = Prestasi::with('mahasiswa')
            ->when($request->user()->tokenCan('mahasiswa'), function ($query) use ($request) {
                return $query->where('mahasiswa_id', $request->user()->id);
            })
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $prestasi
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_lomba' => 'required',
            'juara' => 'required',
            'tingkat_lomba' => 'required',
            'bukti' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $bukti = $request->file('bukti');
        $buktiPath = $bukti->store('bukti_prestasi', 'public');

        $prestasi = Prestasi::create([
            'mahasiswa_id' => $request->user()->id,
            'nama_lomba' => $request->nama_lomba,
            'juara' => $request->juara,
            'tingkat_lomba' => $request->tingkat_lomba,
            'bukti' => $buktiPath,
            'tanggal' => $request->tanggal,
            'deskripsi' => $request->deskripsi,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Prestasi berhasil ditambahkan',
            'data' => $prestasi
        ], 201);
    }

    public function show(Prestasi $prestasi)
    {
        if (!$this->canAccessPrestasi($prestasi)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak'
            ], 403);
        }

        return response()->json([
            'status' => 'success',
            'data' => $prestasi->load('mahasiswa')
        ]);
    }

    public function update(Request $request, Prestasi $prestasi)
    {
        if (!$this->canAccessPrestasi($prestasi)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'nama_lomba' => 'required',
            'juara' => 'required',
            'tingkat_lomba' => 'required',
            'bukti' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->except('bukti');
        
        if ($request->hasFile('bukti')) {
            Storage::disk('public')->delete($prestasi->bukti);
            $data['bukti'] = $request->file('bukti')->store('bukti_prestasi', 'public');
        }

        $prestasi->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Prestasi berhasil diperbarui',
            'data' => $prestasi
        ]);
    }

    public function destroy(Prestasi $prestasi)
    {
        if (!$this->canAccessPrestasi($prestasi)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak'
            ], 403);
        }

        Storage::disk('public')->delete($prestasi->bukti);
        $prestasi->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Prestasi berhasil dihapus'
        ]);
    }

    public function updateStatus(Request $request, Prestasi $prestasi)
    {
        if (!$request->user()->tokenCan('admin')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,diterima,ditolak',
            'catatan_admin' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $prestasi->update([
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Status prestasi berhasil diperbarui',
            'data' => $prestasi
        ]);
    }

    private function canAccessPrestasi($prestasi)
    {
        return request()->user()->tokenCan('admin') || 
               request()->user()->id === $prestasi->mahasiswa_id;
    }
} 