<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Lomba;
use App\Models\Mahasiswa;
use App\Models\Prestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request, $role)
    {
        $validRoles = ['mahasiswa', 'admin'];

        if (!in_array($role, $validRoles)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Role tidak valid',
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $credentials = $request->only('email', 'password');

        switch ($role) {
            case 'mahasiswa':
                $user = Mahasiswa::where('email', $credentials['email'])->first();
                break;
            case 'admin':
                $user = Admin::where('email', $credentials['email'])->first();
                break;
        }

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email atau password salah',
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        $userData = [
            'id' => $user->id,
            'nama' => $user->nama ?? $user->name ?? '',
            'email' => $user->email,
            'role' => $role,
        ];

        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil',
            'data' => [
                'user' => $userData,
                'token' => $token,
            ]
        ]);
    }

    public function logout(Request $request)
    {
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Logout berhasil'
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Tidak ada pengguna yang terautentikasi untuk logout.'
        ], 401);
    }

    public function a(Request $request)
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

        return response()->json([
            'status' => 'success',
            'message' => 'Lomba berhasil dibuat',
        ], 201);
    }

    public function b()
    {
        $lombas = \App\Models\Lomba::orderBy('created_at', 'desc')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil',
            'data' => [
                'lombas' => $lombas
            ]
        ]);
    }

    public function c(Request $request, Lomba $lomba)
    {
        if ($lomba->status !== 'aktif') {
            return redirect()->route('mahasiswa.lomba.index')
                ->with('error', 'Lomba ini sudah tidak aktif.');
        }

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

        return response()->json([
            'status' => 'success',
            'message' => 'Pendaftaran berhasil. Silahkan tunggu konfirmasi dari admin.'
        ], 201);
    }

    public function d(Request $request)
    {
        $request->validate([
            'nama_lomba' => 'required',
            'juara' => 'required',
            'tingkat_lomba' => 'required',
            'bukti' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable',
        ]);

        try {
            $buktiPath = $request->bukti->store('bukti_prestasi', 'public');
        } catch (\Exception $e) {
            Log::error('Gagal menyimpan file bukti: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Gagal menyimpan file bukti.', 'error' => $e->getMessage()], 500);
        }

        Prestasi::create([
            'mahasiswa_id' => auth()->id(),
            'nama_lomba' => $request->nama_lomba,
            'juara' => $request->juara,
            'tingkat_lomba' => $request->tingkat_lomba,
            'bukti' => $buktiPath,
            'tanggal' => $request->tanggal,
            'deskripsi' => $request->deskripsi,
            'status' => 'pending'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Prestasi berhasil ditambahkan',
        ], 201);
    }
}

