<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NomorAntrian;
use App\Models\User;

class ProfileController extends Controller
{
    public function showProfile()
    {
        $user = Auth::user();
        return view('login.profile', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('login.editprofile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'required|string|max:15',
            'religion' => 'required|string|max:255',
            'occupation' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'address' => 'required|string|max:255',
            'nik' => 'required|string|max:16|unique:users,nik,' . $user->id,
        ]);

        $user->update($request->all());

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui.');
    }

    public function show()
    {
        $user = auth()->user();

        $nomorAntrian = NomorAntrian::where('user_id', auth()->id())->first();

        return view('login.profile', compact('user', 'nomorAntrian'));

    }
}
