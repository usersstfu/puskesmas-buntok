<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\User;
use App\Models\NomorAntrian;
use App\Models\AntrianSetting;

class AdminAuthController extends Controller
{

    public function showLoginForm()
    {
        return view('secure.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $admin = Admin::where('email', $credentials['email'])->first();

        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            Auth::guard('admin')->login($admin);
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('admin.login')->withErrors(['email' => 'Email atau password salah']);
    }

    public function dashboard()
    {
        return view('secure.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('admin.login');
    }

    public function index()
    {
        $antrianSetting = AntrianSetting::first();
        return view('secure.pengaturan-antrian', compact('antrianSetting'));
    }

    public function update(Request $request)
    {
        $antrianSetting = AntrianSetting::first();
        if (!$antrianSetting) {
            $antrianSetting = new AntrianSetting();
        }

        $antrianSetting->is_active = $request->input('is_active');
        $antrianSetting->save();

        $statusMessage = $antrianSetting->is_active ? 'Antrian berhasil diaktifkan.' : 'Antrian berhasil dinonaktifkan.';
        return redirect()->back()->with('success', $statusMessage);
    }

    public function daftarPengguna()
    {
        $users = User::all();
        return view('secure.daftar-pengguna', ['users' => $users]);
    }

    public function getQueues()
    {
        $allQueues = [
            'poli_umum' => NomorAntrian::where('ruangan', 'poli_umum')->orderBy('status_prioritas', 'desc')->get(),
            'poli_gigi' => NomorAntrian::where('ruangan', 'poli_gigi')->orderBy('status_prioritas', 'desc')->get(),
            'poli_kia' => NomorAntrian::where('ruangan', 'poli_kia')->orderBy('status_prioritas', 'desc')->get(),
            'poli_anak' => NomorAntrian::where('ruangan', 'poli_anak')->orderBy('status_prioritas', 'desc')->get(),
            'lab' => NomorAntrian::where('ruangan', 'lab')->orderBy('status_prioritas', 'desc')->get(),
            'apotik' => NomorAntrian::where('ruangan', 'apotik')->orderBy('status_prioritas', 'desc')->get(),
        ];

        return $allQueues;
    }

    public function getCurrentQueue($ruangan)
    {
        return NomorAntrian::where('status', 'like', 'sedang_dilayani%')
            ->where('ruangan', $ruangan)
            ->orderBy('status_prioritas', 'desc')
            ->first();
    }


    public function pindahkanNomorAntrian(Request $request)
    {
        $request->validate([
            'nomor_antrian' => 'required|exists:nomorantrian,id',
            'ruangan_tujuan' => 'required|in:poli_gigi,poli_kia,poli_anak,lab,apotik,poli_umum,daftar_tunggu',
        ]);

        $nomorAntrian = NomorAntrian::find($request->nomor_antrian);

        session(['ruangan_asal' => $nomorAntrian->ruangan]);

        $nomorAntrian->ruangan = $request->ruangan_tujuan;

        switch ($nomorAntrian->status) {
            case 'sedang_dilayani':
                $nomorAntrian->status = 'sedang_antri_' . $this->generateUniqueNumber($nomorAntrian->status);
                $nomorAntrian->status_prioritas++;
                break;
            case 'sudah_dilayani':
                break;
            default:
                $nomorAntrian->status = 'sedang_antri_' . $this->generateUniqueNumber($nomorAntrian->status);
                $nomorAntrian->status_prioritas++;
                break;
        }

        $nomorAntrian->save();

        return redirect()->back()->with('success', 'Nomor antrian berhasil dipindahkan ke ' . $request->ruangan_tujuan . '.');
    }

    private function generateUniqueNumber($existingNumber)
    {

        $lastNumber = intval(substr($existingNumber, strrpos($existingNumber, '_') + 1));

        $newNumber = $lastNumber + 1;

        return '' . $newNumber;
    }

    public function panggilKembali(Request $request)
    {
        $request->validate([
            'nomor_antrian' => 'required|exists:nomorantrian,id',
        ]);

        $nomorAntrian = NomorAntrian::find($request->nomor_antrian);


        $nomorAntrian->status = 'sedang_antri';
        $nomorAntrian->save();

        return redirect()->back()->with('success', 'Nomor antrian ' . $nomorAntrian->nomor . ' dipanggil kembali.');
    }

    public function pindahkanKeDaftarTunggu(Request $request)
    {
        $request->validate([
            'nomor_antrian' => 'required|exists:nomorantrian,id',
        ]);

        $nomorAntrian = NomorAntrian::find($request->nomor_antrian);

        session(['ruangan_asal' => $nomorAntrian->ruangan]);

        $nomorAntrian->status = 'daftar_tunggu';
        $nomorAntrian->save();

        return redirect()->back()->with('success', 'Nomor antrian berhasil dipindahkan ke Daftar Tunggu.');
    }


    public function showPoliUmumPage()
    {
        $allQueues = $this->getQueues();
        $currentQueue = $this->getCurrentQueue('poli_umum');
        $currentQueueNumber = $currentQueue ? $currentQueue->nomor : 0;

        $nextQueues = [];
        foreach ($allQueues as $ruangan => $queues) {
            $nextQueue = NomorAntrian::where('status', 'sedang_antri')
                ->where('ruangan', $ruangan)
                ->orderBy('nomor')
                ->first();

            $nextQueues[$ruangan] = $nextQueue;
        }

        return view('secure.poli-umum', [
            'allQueues' => $allQueues,
            'currentQueue' => $currentQueue,
            'currentQueueNumber' => $currentQueueNumber,
            'nextQueues' => $nextQueues,
        ]);
    }


    public function startQueuePoliUmum()
    {
        $ruangan = 'poli_umum';

        $firstQueue = NomorAntrian::where('ruangan', $ruangan)
            ->where('status', 'like', 'sedang_antri%')
            ->orderBy('nomor')
            ->first();

        if (!$firstQueue) {
            return redirect()->back()->with('error', 'Tidak ada nomor antrian yang sedang antri di ruangan ' . $ruangan . '.');
        }

        $currentStatus = $firstQueue->status;
        $currentNumber = preg_replace('/\D/', '', $currentStatus);

        if ($currentNumber !== '') {
            $newStatus = 'sedang_dilayani_' . $currentNumber;
        } else {
            $newStatus = 'sedang_dilayani';
        }

        $firstQueue->update(['status' => $newStatus]);

        $currentQueue = NomorAntrian::find($firstQueue->id);

        return redirect()->back()->with([
            'success' => 'Antrian di ruangan ' . $ruangan . ' telah dimulai.',
            'currentQueue' => $currentQueue,
        ]);
    }

    public function selesaikanAntrianPoliUmum(Request $request)
    {
        $request->validate([
            'nomor_antrian' => 'required|exists:nomorantrian,id',
        ]);

        $nomorAntrian = NomorAntrian::findOrFail($request->nomor_antrian);

        $ruangan_asal = session('ruangan_asal');

        $nomorAntrian->status = 'sudah_dilayani';

        switch ($ruangan_asal) {
            case 'poli_gigi':
            case 'poli_kia':
            case 'poli_anak':
            case 'lab':
            case 'apotik':
                $nomorAntrian->ruangan = $ruangan_asal;
                break;
            default:
                $nomorAntrian->ruangan = 'poli_umum';
                break;
        }

        $nomorAntrian->save();

        return redirect()->back()->with('success', 'Antrian telah selesai dilayani.');
    }


    public function showGigiUmumPage()
    {
        $allQueues = $this->getQueues();
        $currentQueue = $this->getCurrentQueue('poli_gigi');
        $currentQueueNumber = $currentQueue ? $currentQueue->nomor : 0;

        $nextQueues = [];
        foreach ($allQueues as $ruangan => $queues) {
            $nextQueue = NomorAntrian::where('status', 'sedang_antri')
                ->where('ruangan', $ruangan)
                ->orderBy('nomor')
                ->first();

            $nextQueues[$ruangan] = $nextQueue;
        }

        return view('secure.poli-gigi', [
            'allQueues' => $allQueues,
            'currentQueue' => $currentQueue,
            'currentQueueNumber' => $currentQueueNumber,
            'nextQueues' => $nextQueues,
        ]);
    }

    public function selesaikanAntrianPoliGigi(Request $request)
    {
        $request->validate([
            'nomor_antrian' => 'required|exists:nomorantrian,id',
        ]);

        $nomorAntrian = NomorAntrian::findOrFail($request->nomor_antrian);

        $ruangan_asal = session('ruangan_asal');

        $nomorAntrian->status = 'sudah_dilayani';

        switch ($ruangan_asal) {
            case 'poli_gigi':
            case 'poli_kia':
            case 'poli_anak':
            case 'lab':
            case 'apotik':
                $nomorAntrian->ruangan = $ruangan_asal;
                break;
            default:
                $nomorAntrian->ruangan = 'poli_umum';
                break;
        }

        $nomorAntrian->save();

        return redirect()->back()->with('success', 'Antrian telah selesai dilayani.');
    }

    public function startQueuePoliGigi()
    {
        $ruangan = 'poli_gigi';

        $firstQueue = NomorAntrian::where('ruangan', $ruangan)
            ->where('status', 'like', 'sedang_antri%')
            ->orderBy('nomor')
            ->first();

        if (!$firstQueue) {
            return redirect()->back()->with('error', 'Tidak ada nomor antrian yang sedang antri di ruangan ' . $ruangan . '.');
        }

        $currentStatus = $firstQueue->status;
        $currentNumber = preg_replace('/\D/', '', $currentStatus);

        if ($currentNumber !== '') {
            $newStatus = 'sedang_dilayani_' . $currentNumber;
        } else {
            $newStatus = 'sedang_dilayani';
        }

        $firstQueue->update(['status' => $newStatus]);

        $currentQueue = NomorAntrian::find($firstQueue->id);

        return redirect()->back()->with([
            'success' => 'Antrian di ruangan ' . $ruangan . ' telah dimulai.',
            'currentQueue' => $currentQueue,
        ]);
    }


    public function showKiaUmumPage()
    {
        $allQueues = $this->getQueues();
        $currentQueue = $this->getCurrentQueue('poli_kia');
        $currentQueueNumber = $currentQueue ? $currentQueue->nomor : 0;

        $nextQueues = [];
        foreach ($allQueues as $ruangan => $queues) {
            $nextQueue = NomorAntrian::where('status', 'sedang_antri')
                ->where('ruangan', $ruangan)
                ->orderBy('nomor')
                ->first();

            $nextQueues[$ruangan] = $nextQueue;
        }

        return view('secure.poli-kia', [
            'allQueues' => $allQueues,
            'currentQueue' => $currentQueue,
            'currentQueueNumber' => $currentQueueNumber,
            'nextQueues' => $nextQueues,
        ]);
    }

    public function startQueuePoliKia()
    {
        $ruangan = 'poli_kia';

        $firstQueue = NomorAntrian::where('ruangan', $ruangan)
            ->where('status', 'like', 'sedang_antri%')
            ->orderBy('nomor')
            ->first();

        if (!$firstQueue) {
            return redirect()->back()->with('error', 'Tidak ada nomor antrian yang sedang antri di ruangan ' . $ruangan . '.');
        }

        $currentStatus = $firstQueue->status;
        $currentNumber = preg_replace('/\D/', '', $currentStatus);

        if ($currentNumber !== '') {
            $newStatus = 'sedang_dilayani_' . $currentNumber;
        } else {
            $newStatus = 'sedang_dilayani';
        }

        $firstQueue->update(['status' => $newStatus]);

        $currentQueue = NomorAntrian::find($firstQueue->id);

        return redirect()->back()->with([
            'success' => 'Antrian di ruangan ' . $ruangan . ' telah dimulai.',
            'currentQueue' => $currentQueue,
        ]);
    }

    public function selesaikanAntrianPoliKia(Request $request)
    {
        $request->validate([
            'nomor_antrian' => 'required|exists:nomorantrian,id',
        ]);

        $nomorAntrian = NomorAntrian::findOrFail($request->nomor_antrian);

        $ruangan_asal = session('ruangan_asal');

        $nomorAntrian->status = 'sudah_dilayani';

        switch ($ruangan_asal) {
            case 'poli_gigi':
            case 'poli_kia':
            case 'poli_anak':
            case 'lab':
            case 'apotik':
                $nomorAntrian->ruangan = $ruangan_asal;
                break;
            default:
                $nomorAntrian->ruangan = 'poli_umum';
                break;
        }

        $nomorAntrian->save();

        return redirect()->back()->with('success', 'Antrian telah selesai dilayani.');
    }

    public function showAnakUmumPage()
    {
        $allQueues = $this->getQueues();
        $currentQueue = $this->getCurrentQueue('poli_anak');
        $currentQueueNumber = $currentQueue ? $currentQueue->nomor : 0;

        $nextQueues = [];
        foreach ($allQueues as $ruangan => $queues) {
            $nextQueue = NomorAntrian::where('status', 'sedang_antri')
                ->where('ruangan', $ruangan)
                ->orderBy('nomor')
                ->first();

            $nextQueues[$ruangan] = $nextQueue;
        }

        return view('secure.poli-anak', [
            'allQueues' => $allQueues,
            'currentQueue' => $currentQueue,
            'currentQueueNumber' => $currentQueueNumber,
            'nextQueues' => $nextQueues,
        ]);
    }

    public function startQueuePoliAnak()
    {
        $ruangan = 'poli_anak';

        $firstQueue = NomorAntrian::where('ruangan', $ruangan)
            ->where('status', 'like', 'sedang_antri%')
            ->orderBy('nomor')
            ->first();

        if (!$firstQueue) {
            return redirect()->back()->with('error', 'Tidak ada nomor antrian yang sedang antri di ruangan ' . $ruangan . '.');
        }

        $currentStatus = $firstQueue->status;
        $currentNumber = preg_replace('/\D/', '', $currentStatus);

        if ($currentNumber !== '') {
            $newStatus = 'sedang_dilayani_' . $currentNumber;
        } else {
            $newStatus = 'sedang_dilayani';
        }

        $firstQueue->update(['status' => $newStatus]);

        $currentQueue = NomorAntrian::find($firstQueue->id);

        return redirect()->back()->with([
            'success' => 'Antrian di ruangan ' . $ruangan . ' telah dimulai.',
            'currentQueue' => $currentQueue,
        ]);
    }

    public function selesaikanAntrianPoliAnak(Request $request)
    {
        $request->validate([
            'nomor_antrian' => 'required|exists:nomorantrian,id',
        ]);

        $nomorAntrian = NomorAntrian::findOrFail($request->nomor_antrian);

        $ruangan_asal = session('ruangan_asal');

        $nomorAntrian->status = 'sudah_dilayani';

        switch ($ruangan_asal) {
            case 'poli_gigi':
            case 'poli_kia':
            case 'poli_anak':
            case 'lab':
            case 'apotik':
                $nomorAntrian->ruangan = $ruangan_asal;
                break;
            default:
                $nomorAntrian->ruangan = 'poli_umum';
                break;
        }

        $nomorAntrian->save();

        return redirect()->back()->with('success', 'Antrian telah selesai dilayani.');
    }

    public function showLabUmumPage()
    {
        $allQueues = $this->getQueues();
        $currentQueue = $this->getCurrentQueue('lab');
        $currentQueueNumber = $currentQueue ? $currentQueue->nomor : 0;

        $nextQueues = [];
        foreach ($allQueues as $ruangan => $queues) {
            $nextQueue = NomorAntrian::where('status', 'sedang_antri')
                ->where('ruangan', $ruangan)
                ->orderBy('nomor')
                ->first();

            $nextQueues[$ruangan] = $nextQueue;
        }

        return view('secure.lab', [
            'allQueues' => $allQueues,
            'currentQueue' => $currentQueue,
            'currentQueueNumber' => $currentQueueNumber,
            'nextQueues' => $nextQueues,
        ]);
    }

    public function startQueueLab()
    {
        $ruangan = 'lab';

        $firstQueue = NomorAntrian::where('ruangan', $ruangan)
            ->where('status', 'like', 'sedang_antri%')
            ->orderBy('nomor')
            ->first();

        if (!$firstQueue) {
            return redirect()->back()->with('error', 'Tidak ada nomor antrian yang sedang antri di ruangan ' . $ruangan . '.');
        }

        $currentStatus = $firstQueue->status;
        $currentNumber = preg_replace('/\D/', '', $currentStatus);

        if ($currentNumber !== '') {
            $newStatus = 'sedang_dilayani_' . $currentNumber;
        } else {
            $newStatus = 'sedang_dilayani';
        }

        $firstQueue->update(['status' => $newStatus]);

        $currentQueue = NomorAntrian::find($firstQueue->id);

        return redirect()->back()->with([
            'success' => 'Antrian di ruangan ' . $ruangan . ' telah dimulai.',
            'currentQueue' => $currentQueue,
        ]);
    }

    public function selesaikanAntrianLab(Request $request)
    {
        $request->validate([
            'nomor_antrian' => 'required|exists:nomorantrian,id',
        ]);

        $nomorAntrian = NomorAntrian::findOrFail($request->nomor_antrian);

        $ruangan_asal = session('ruangan_asal');

        $nomorAntrian->status = 'sudah_dilayani';

        switch ($ruangan_asal) {
            case 'poli_gigi':
            case 'poli_kia':
            case 'poli_anak':
            case 'lab':
            case 'apotik':
                $nomorAntrian->ruangan = $ruangan_asal;
                break;
            default:
                $nomorAntrian->ruangan = 'poli_umum';
                break;
        }

        $nomorAntrian->save();

        return redirect()->back()->with('success', 'Antrian telah selesai dilayani.');
    }

    public function showApotikUmumPage()
    {
        $allQueues = $this->getQueues();
        $currentQueue = $this->getCurrentQueue('apotik');
        $currentQueueNumber = $currentQueue ? $currentQueue->nomor : 0;
        $nextQueues = [];
        foreach ($allQueues as $ruangan => $queues) {
            $nextQueue = NomorAntrian::where('status', 'sedang_antri')
                ->where('ruangan', $ruangan)
                ->orderBy('nomor')
                ->first();

            $nextQueues[$ruangan] = $nextQueue;
        }

        return view('secure.apotik', [
            'allQueues' => $allQueues,
            'currentQueue' => $currentQueue,
            'currentQueueNumber' => $currentQueueNumber,
            'nextQueues' => $nextQueues,
        ]);
    }

    public function startQueueApotik()
    {
        $ruangan = 'apotik';

        $firstQueue = NomorAntrian::where('ruangan', $ruangan)
            ->where('status', 'like', 'sedang_antri%')
            ->orderBy('nomor')
            ->first();

        if (!$firstQueue) {
            return redirect()->back()->with('error', 'Tidak ada nomor antrian yang sedang antri di ruangan ' . $ruangan . '.');
        }

        $currentStatus = $firstQueue->status;
        $currentNumber = preg_replace('/\D/', '', $currentStatus);

        if ($currentNumber !== '') {
            $newStatus = 'sedang_dilayani_' . $currentNumber;
        } else {
            $newStatus = 'sedang_dilayani';
        }

        $firstQueue->update(['status' => $newStatus]);

        $currentQueue = NomorAntrian::find($firstQueue->id);

        return redirect()->back()->with([
            'success' => 'Antrian di ruangan ' . $ruangan . ' telah dimulai.',
            'currentQueue' => $currentQueue,
        ]);
    }

    public function selesaikanAntrianApotik(Request $request)
    {
        $request->validate([
            'nomor_antrian' => 'required|exists:nomorantrian,id',
        ]);

        $nomorAntrian = NomorAntrian::findOrFail($request->nomor_antrian);

        // Simpan ruangan asal sebelum memindahkan
        $ruangan_asal = session('ruangan_asal');

        $nomorAntrian->status = 'sudah_dilayani';

        switch ($ruangan_asal) {
            case 'poli_gigi':
            case 'poli_kia':
            case 'poli_anak':
            case 'lab':
            case 'apotik':
                $nomorAntrian->ruangan = $ruangan_asal;
                break;
            default:
                $nomorAntrian->ruangan = 'poli_umum';
                break;
        }

        $nomorAntrian->save();

        return redirect()->back()->with('success', 'Antrian telah selesai dilayani.');
    }
}
