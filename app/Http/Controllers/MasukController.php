<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class MasukController extends Controller
{
    public function tampilkanFormMasuk()
    {
        return view('login.masuk');
    }

    public function prosesMasuk(Request $request)
    {
        $credentials = $request->only('nik', 'password');

        if (Auth::guard('web')->attempt($credentials)) {
            return redirect()->route('profile.show');
        }

        return redirect()->back()->withErrors(['error' => 'NIK atau Password salah.']);
    }


    public function logout()
    {
        Auth::guard('web')->logout();
        Session::flash('logout_message', 'Anda telah berhasil logout.');
        return redirect()->route('home');
    }
}
