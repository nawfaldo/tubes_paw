<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lomba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class LombaController extends Controller
{
    public function index()
    {
        $lomba = Lomba::latest()->get();

        return response()->json([
            'status' => 'success',
            'data' => $lomba
        ]);
    }

    public function store(Request $request)
    {
        if (!$request->user()->tokenCan('admin')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'nama_lomba' => 'required',
            'deskripsi' => 'required',
            'deadline_pendaftaran' => 'required|date',
            'link_pendaftaran' => 'required|url',
            'poster' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'tingkat_lomba' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $poster = $request->file('poster');
        $posterPath = $poster->store('poster_lomba', 'public');

        $lomba = Lomba::create([
            'nama_lomba' => $request->nama_lomba,
            'deskripsi' => $request->deskripsi,
            'deadline_pendaftaran' => $request->deadline_pendaftaran,
            'link_pendaftaran' => $request->link_pendaftaran,
            'poster' => $posterPath,
            'tingkat_lomba' => $request->tingkat_lomba,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Lomba berhasil ditambahkan',
            'data' => $lomba
        ], 201);
    }

    public function show(Lomba $lomba)
    {
        return response()->json([
            'status' => 'success',
            'data' => $lomba
        ]);
    }

    public function update(Request $request, Lomba $lomba)
    {
        if (!$request->user()->tokenCan('admin')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'nama_lomba' => 'required',
            'deskripsi' => 'required',
            'deadline_pendaftaran' => 'required|date',
            'link_pendaftaran' => 'required|url',
            'poster' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tingkat_lomba' => 'required',
            'status' => 'required|in:aktif,selesai,dibatalkan',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->except('poster');
        
        if ($request->hasFile('poster')) {
            Storage::disk('public')->delete($lomba->poster);
            $data['poster'] = $request->file('poster')->store('poster_lomba', 'public');
        }

        $lomba->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Lomba berhasil diperbarui',
            'data' => $lomba
        ]);
    }

    public function destroy(Request $request, Lomba $lomba)
    {
        if (!$request->user()->tokenCan('admin')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak'
            ], 403);
        }

        Storage::disk('public')->delete($lomba->poster);
        $lomba->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Lomba berhasil dihapus'
        ]);
    }
} 