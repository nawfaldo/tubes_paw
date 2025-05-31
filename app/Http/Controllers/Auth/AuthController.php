<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showRoleSelection()
    {
        return view('auth.role-selection');
    }

    public function showLogin($role)
    {
        if (!in_array($role, ['mahasiswa', 'admin'])) {
            return redirect()->route('role.selection');
        }
        return view('auth.login', ['role' => $role]);
    }

    public function showRegister($role)
    {
        if ($role !== 'mahasiswa') {
            return redirect()->route('role.selection');
        }
        return view('auth.register', ['role' => $role]);
    }

    public function login(Request $request, $role)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('email', 'password');
        
        if (Auth::guard($role)->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route($role . '.dashboard');
        }

        return redirect()->back()
            ->withErrors(['email' => 'Email atau password salah'])
            ->withInput();
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nim' => 'required|unique:mahasiswa',
            'nama' => 'required',
            'email' => 'required|email|unique:mahasiswa',
            'password' => 'required|min:6|confirmed',
            'jurusan' => 'required',
            'fakultas' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $mahasiswa = Mahasiswa::create([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'jurusan' => $request->jurusan,
            'fakultas' => $request->fakultas,
        ]);

        Auth::guard('mahasiswa')->login($mahasiswa);
        return redirect()->route('mahasiswa.dashboard');
    }

    public function logout(Request $request)
    {
        $role = Auth::guard('mahasiswa')->check() ? 'mahasiswa' : 'admin';
        Auth::guard($role)->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('role.selection');
    }
} 