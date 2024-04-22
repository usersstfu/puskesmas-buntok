<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NomorAntrian;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\AntrianSetting;
use App\Models\User;

class DaftarAntrianController extends Controller
{
    public function tampilkanFormDaftar()
    {
        $user = auth()->user();
        if (!$user) {
            return view('daftar-antrian')->with('login_required', true);
        }

        $antrianSetting = AntrianSetting::first();
        return view('daftar-antrian', compact('antrianSetting', 'user'));
    }

    public function tampilkanHalamanDaftarAntrian()
    {
        $antrianSetting = AntrianSetting::first();
        return view('daftar-antrian', compact('antrianSetting'));
    }

    public function prosesDaftar(Request $request)
    {
        $request->validate([
            'ruangan' => 'required|in:poli_umum,poli_gigi,poli_kia,poli_anak,lab,apotik',
        ]);

        $user = auth()->user();
        if (!$user) {
            return redirect()->back()->with('error', 'Anda harus login untuk mendaftar nomor antrian.');
        }

        $ruangan = $request->input('ruangan');
        $today = Carbon::now()->toDateString();
        $alreadyRegistered = NomorAntrian::where('user_id', $user->id)
            ->where('ruangan', $ruangan)
            ->whereDate('created_at', $today)
            ->exists();

        if ($alreadyRegistered) {
            return redirect()->back()->with('error', 'Anda sudah mendaftar nomor antrian untuk ruangan ini hari ini.');
        }

        $nomorAntrian = new NomorAntrian();
        $nomorAntrian->nama = $user->name;
        $nomorAntrian->nik = $user->nik;
        $nomorAntrian->ruangan = $ruangan;
        $nomorAntrian->user_id = $user->id;
        $nomorAntrian->status_prioritas = 1;

        try {
            $birthdate = Carbon::createFromFormat('Y-m-d', $user->birthdate);
            $usia = $birthdate->diffInYears(Carbon::now());
            $prioritas = $usia >= 60 ? 'usia' : 'umum';
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Invalid birthdate format. Please enter the birthdate in the format YYYY-MM-DD.');
        }

        $kodeRuangan = '';
        switch ($ruangan) {
            case 'poli_umum':
                $kodeRuangan = 'A';
                break;
            case 'poli_gigi':
                $kodeRuangan = 'B';
                break;
            case 'poli_kia':
                $kodeRuangan = 'C';
                break;
            case 'poli_anak':
                $kodeRuangan = 'D';
                break;
            case 'lab':
                $kodeRuangan = 'LAB';
                break;
            case 'apotik':
                $kodeRuangan = 'APT';
                break;
            default:
                break;
        }

        $lastQueue = NomorAntrian::where('ruangan', $ruangan)->latest()->first();
        $lastQueueNumber = $lastQueue ? intval(substr($lastQueue->nomor, 1)) : 0;
        $nomorAntrian->nomor = $kodeRuangan . ($lastQueueNumber + 1);
        $nomorAntrian->prioritas = $prioritas;
        $nomorAntrian->save();

        return redirect()->route('lihat-antrian')->with('success', 'Nomor antrian Anda telah didaftarkan.');
    }
}
