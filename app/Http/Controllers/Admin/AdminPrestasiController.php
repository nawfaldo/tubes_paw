<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use Illuminate\Http\Request;

class AdminPrestasiController extends Controller
{
    
    public function index()
    {
        $prestasis = Prestasi::with('mahasiswa')->orderBy('created_at', 'desc')->get();
        return view('admin.prestasi.index', compact('prestasis'));
    }

    public function approve($id)
    {
        $prestasi = Prestasi::findOrFail($id);
        $prestasi->status = 'diterima';
        $prestasi->save();
        return redirect()->back()->with('success', 'Prestasi berhasil di-approve.');
    }

   
    public function reject($id)
    {
        $prestasi = Prestasi::findOrFail($id);
        $prestasi->status = 'ditolak';
        $prestasi->save();
        return redirect()->back()->with('success', 'Prestasi berhasil di-reject.');
    }
} 