<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DaftarController extends Controller
{
    public function tampilkanFormDaftar()
    {
        return view('login.daftar');
    }

    public function prosesPendaftaran(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|max:15',
            'religion' => 'required|string|max:255',
            'occupation' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'address' => 'required|string',
            'ktp' => 'nullable|file|max:2048',
            'bpjs_card' => 'nullable|file|max:2048',
            'puskesmas_card' => 'nullable|file|max:2048',
            'nik' => 'required|string|max:255|unique:users,nik',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->phone_number = $validatedData['phone_number'];
        $user->religion = $validatedData['religion'];
        $user->occupation = $validatedData['occupation'];
        $user->birthdate = $validatedData['birthdate'];
        $user->address = $validatedData['address'];
        $user->nik = $validatedData['nik'];
        $user->password = bcrypt($validatedData['password']);
        if ($request->hasFile('ktp')) {
            $user->ktp = $request->file('ktp')->store('ktp');
        }
        if ($request->hasFile('bpjs_card')) {
            $user->bpjs_card = $request->file('bpjs_card')->store('bpjs_card');
        }
        if ($request->hasFile('puskesmas_card')) {
            $user->puskesmas_card = $request->file('puskesmas_card')->store('puskesmas_card');
        }
        $user->save();
        return redirect()->route('login')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }
}
