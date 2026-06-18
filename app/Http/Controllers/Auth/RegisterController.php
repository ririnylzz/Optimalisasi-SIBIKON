<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Menyimpan data user baru (proses registrasi)
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:255',
            'nik' => 'required|size:16|unique:users,nik',
            'email' => 'required|email|unique:users,email',
            'telepon' => 'required|max:20',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->nama,
            'nik' => $request->nik,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Registrasi berhasil');
    }
}