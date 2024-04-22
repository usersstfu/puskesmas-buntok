<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NomorAntrian;
use Illuminate\Support\Facades\Auth;

class LihatAntrianController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return view('lihat-antrian')->with('login_required', true);
        }

        $nomorAntrian = NomorAntrian::where('user_id', auth()->id())->first();

        $currentQueues = $this->getQueues();

        $nextQueues = [];
        foreach ($currentQueues as $ruangan => $currentQueue) {
            if ($currentQueue) {
                $nextQueue = NomorAntrian::where('ruangan', $ruangan)
                    ->where(function ($query) use ($currentQueue) {
                        $query->where('status', 'like', 'sedang_dilayani%')
                            ->orWhere('status', 'like', $currentQueue->status . '_%');
                    })
                    ->where('nomor', '>', $currentQueue->nomor)
                    ->orderBy('nomor')
                    ->first();
                $nextQueues[$ruangan] = $nextQueue;
            } else {
                $nextQueues[$ruangan] = null;
            }
        }

        return view('lihat-antrian', compact('nomorAntrian', 'currentQueues', 'nextQueues'));
    }


    private function getQueues()
    {
        $currentQueues = [
            'poli_umum' => $this->getCurrentQueue('poli_umum'),
            'poli_gigi' => $this->getCurrentQueue('poli_gigi'),
            'poli_kia' => $this->getCurrentQueue('poli_kia'),
            'poli_anak' => $this->getCurrentQueue('poli_anak'),
            'lab' => $this->getCurrentQueue('lab'),
            'apotik' => $this->getCurrentQueue('apotik'),
        ];

        return $currentQueues;
    }

    public function getCurrentQueue($ruangan)
    {
        return NomorAntrian::where('status', 'like', 'sedang_dilayani%')
            ->where('ruangan', $ruangan)
            ->first();
    }

    public function getAllAntrian(Request $request)
    {
        $room = $request->input('room');
        $queues = NomorAntrian::where('ruangan', $room)->get();
        return response()->json($queues);
    }

    public function getWaitList(Request $request)
    {
        $room = $request->input('room');
        $queues = NomorAntrian::where('ruangan', $room)
            ->where('status', 'daftar_tunggu')
            ->get();
        return response()->json($queues);
    }
}
