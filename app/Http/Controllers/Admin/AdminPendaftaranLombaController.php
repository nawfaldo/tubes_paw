<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lomba;
use Illuminate\Support\Facades\storage;
use Illuminate\Support\Facades\Validator;

class AdminPendaftaranLombaController extends Controller
{
    public function index()
    {
        $lombas = Lomba::latest()->paginate(10); 
        return view('admin.lomba.index', compact('lombas'));
    }
    public function create()
    {
        return view('admin.lomba.create');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'description' => 'required|string',
            'deadline' => 'required|date',
            'link' => 'required|url|max:100',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tingkatan_lomba_id' => 'required|integer|exists:tingkatan_lombas,id',
        ]);
    }
}
