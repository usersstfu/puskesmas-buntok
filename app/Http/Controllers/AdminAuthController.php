<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\User;
use App\Models\NomorAntrian;
use App\Models\AntrianSetting;
use App\Models\Visitor;
use App\Models\RiwayatNomorAntrian;
use App\Models\Contact;
use Phpml\ModelManager;
use Carbon\Carbon;

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
        $visitorsData = Visitor::selectRaw('COUNT(*) as count, DATE(created_at) as date')
            ->whereDate('created_at', '>=', Carbon::now()->startOfMonth())
            ->whereDate('created_at', '<=', Carbon::now()->endOfMonth())
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count')
            ->toArray();

        $visitorsLabels = Visitor::selectRaw('DATE(created_at) as date')
            ->whereDate('created_at', '>=', Carbon::now()->startOfMonth())
            ->whereDate('created_at', '<=', Carbon::now()->endOfMonth())
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('date')
            ->toArray();

        $totalVisitorsThisMonth = Visitor::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();

        $queueData = RiwayatNomorAntrian::selectRaw('COUNT(*) as count, DATE(created_at) as date')
            ->whereDate('created_at', '>=', Carbon::now()->startOfMonth())
            ->whereDate('created_at', '<=', Carbon::now()->endOfMonth())
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count')
            ->toArray();

        $queueRegistrationsCount = RiwayatNomorAntrian::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();

        $registrationData = User::selectRaw('COUNT(*) as count, DATE(created_at) as date')
            ->whereDate('created_at', '>=', Carbon::now()->startOfMonth())
            ->whereDate('created_at', '<=', Carbon::now()->endOfMonth())
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count')
            ->toArray();

        $accountRegistrationsCount = User::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();

        $labels = collect(range(1, count($queueData)))->map(function ($i) {
            return Carbon::now()->startOfMonth()->addDays($i - 1)->format('M d');
        })->toArray();

        return view('secure.dashboard', [
            'visitorsData' => json_encode($visitorsData),
            'visitorsLabels' => json_encode($labels),
            'queueData' => json_encode($queueData),
            'queueLabels' => json_encode($labels),
            'registrationData' => json_encode($registrationData),
            'registrationLabels' => json_encode($labels),
            'queueRegistrationsCount' => $queueRegistrationsCount,
            'accountRegistrationsCount' => $accountRegistrationsCount,
            'totalVisitorsThisMonth' => $totalVisitorsThisMonth,
        ]);
    }


    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function index()
    {
        $antrianSetting = AntrianSetting::first();
        return view('secure.pengaturan-antrian', compact('antrianSetting'));
    }

    public function showKontakPage()
    {
        $contacts = Contact::all();
        return view('secure.kontak-index', compact('contacts'));
    }

    public function showPrioritasPage()
    {
        $allQueues = NomorAntrian::where('status', '!=', 'sudah_dilayani')->orderBy('nomor')->get();

        return view('secure.prioritas', compact('allQueues'));
    }

    public function indexRiwayatAntrian(Request $request)
    {
        $search = $request->input('search');
        $tanggal = $request->input('tanggal');
        $query = RiwayatNomorAntrian::query();

        if ($tanggal) {
            $query->whereDate('created_at', '=', $tanggal);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nomor', 'like', "%{$search}%");
            });
        }

        $riwayatAntrian = $query->get();

        return view('secure.riwayat-antrian', ['riwayatAntrian' => $riwayatAntrian]);
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

    public function showUserDetail($id)
    {
        $user = User::findOrFail($id);

        return view('secure.detail-pengguna', ['user' => $user]);
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

        $ruanganTujuan = $request->input('ruangan_tujuan');

        $kodeRuanganTujuan = $this->ruanganToNumeric($ruanganTujuan);

        $nomorAntrian = NomorAntrian::find($request->nomor_antrian);

        $nomor = intval(substr($nomorAntrian->nomor, 1));

        $waktuTotalSistem = $this->predictAntrian($nomor, $kodeRuanganTujuan, $nomorAntrian->status_prioritas, strtotime($nomorAntrian->created_at));
        $nomorAntrian->waktu_total_sistem = $waktuTotalSistem;

        session(['ruangan_asal' => $nomorAntrian->ruangan]);

        $nomorAntrian->ruangan = $ruanganTujuan;

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

    private function ruanganToNumeric($ruangan)
    {
        $map = [
            'poli_umum' => '1',
            'poli_gigi' => '2',
            'poli_kia' => '3',
            'poli_anak' => '4',
            'lab' => '5',
            'apotik' => '6',
        ];
        return isset($map[$ruangan]) ? $map[$ruangan] : 0;
    }

    private function predictAntrian($nomor, $ruangan, $status_prioritas, $created_at)
    {
        $modelPath = public_path('model/antrianModel.pkl');

        if (!file_exists($modelPath)) {
            return response()->json(['error' => 'Model file not found'], 404);
        }

        $modelManager = new ModelManager();
        $regression = $modelManager->restoreFromFile(($modelPath));
        $prediksi = $regression->predict([[$nomor, $ruangan, $status_prioritas, $created_at]]);

        return $prediksi[0];
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

    public function berikanPrioritas(Request $request)
    {
        $request->validate([
            'nomor_antrian' => 'required|exists:nomorantrian,id',
            'alasan_prioritas' => 'required|string|max:255',
        ]);

        $nomorAntrian = NomorAntrian::find($request->nomor_antrian);

        $nomorAntrian->prioritas = 'didahulukan';
        $nomorAntrian->status_prioritas = 20;
        $nomorAntrian->alasan_prioritas = $request->alasan_prioritas;
        $nomorAntrian->save();

        return redirect()->back()->with('success', 'Nomor antrian ' . $nomorAntrian->nomor . ' telah diberikan prioritas dengan alasan: ' . $request->alasan_prioritas);
    }

    public function updateStatusPembayaran(Request $request)
    {
        $request->validate([
            'nomor_antrian_id' => 'required|exists:nomorantrian,id',
            'status_pembayaran' => 'required|in:Belum Lunas,Sudah Lunas,BPJS',
        ]);

        $nomorAntrian = NomorAntrian::find($request->nomor_antrian_id);
        $nomorAntrian->status_pembayaran = $request->status_pembayaran;
        $nomorAntrian->save();

        return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }


    public function showPoliUmumPage()
    {
        $today = Carbon::today()->toDateString();

        $allQueues = NomorAntrian::whereDate('created_at', $today)
            ->orderBy('nomor')
            ->get()
            ->groupBy('ruangan');

        $currentQueue = NomorAntrian::whereDate('created_at', $today)
            ->where('ruangan', 'poli_umum')
            ->where('status', 'sedang_dilayani')
            ->orderBy('nomor')
            ->first();

        $currentQueueNumber = $currentQueue ? $currentQueue->nomor : 0;

        $nextQueues = [];
        foreach ($allQueues as $ruangan => $queues) {
            $nextQueue = NomorAntrian::whereDate('created_at', $today)
                ->where('status', 'sedang_antri')
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

        $ruangan_asal = $nomorAntrian->ruangan_asal;

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
        $today = Carbon::today()->toDateString();

        $allQueues = NomorAntrian::whereDate('created_at', $today)
            ->orderBy('nomor')
            ->get()
            ->groupBy('ruangan');

        $currentQueue = NomorAntrian::whereDate('created_at', $today)
            ->where('ruangan', 'poli_gigi')
            ->where('status', 'sedang_dilayani')
            ->orderBy('nomor')
            ->first();

        $currentQueueNumber = $currentQueue ? $currentQueue->nomor : 0;

        $nextQueues = [];
        foreach ($allQueues as $ruangan => $queues) {
            $nextQueue = NomorAntrian::whereDate('created_at', $today)
                ->where('status', 'sedang_antri')
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

        $ruangan_asal = $nomorAntrian->ruangan_asal;

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
        $today = Carbon::today()->toDateString();

        $allQueues = NomorAntrian::whereDate('created_at', $today)
            ->orderBy('nomor')
            ->get()
            ->groupBy('ruangan');

        $currentQueue = NomorAntrian::whereDate('created_at', $today)
            ->where('ruangan', 'poli_kia')
            ->where('status', 'sedang_dilayani')
            ->orderBy('nomor')
            ->first();

        $currentQueueNumber = $currentQueue ? $currentQueue->nomor : 0;

        $nextQueues = [];
        foreach ($allQueues as $ruangan => $queues) {
            $nextQueue = NomorAntrian::whereDate('created_at', $today)
                ->where('status', 'sedang_antri')
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

        $ruangan_asal = $nomorAntrian->ruangan_asal;

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
        $today = Carbon::today()->toDateString();

        $allQueues = NomorAntrian::whereDate('created_at', $today)
            ->orderBy('nomor')
            ->get()
            ->groupBy('ruangan');

        $currentQueue = NomorAntrian::whereDate('created_at', $today)
            ->where('ruangan', 'poli_anak')
            ->where('status', 'sedang_dilayani')
            ->orderBy('nomor')
            ->first();

        $currentQueueNumber = $currentQueue ? $currentQueue->nomor : 0;

        $nextQueues = [];
        foreach ($allQueues as $ruangan => $queues) {
            $nextQueue = NomorAntrian::whereDate('created_at', $today)
                ->where('status', 'sedang_antri')
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

        $ruangan_asal = $nomorAntrian->ruangan_asal;

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
        $today = Carbon::today()->toDateString();

        $allQueues = NomorAntrian::whereDate('created_at', $today)
            ->orderBy('nomor')
            ->get()
            ->groupBy('ruangan');

        $currentQueue = NomorAntrian::whereDate('created_at', $today)
            ->where('ruangan', 'lab')
            ->where('status', 'sedang_dilayani')
            ->orderBy('nomor')
            ->first();

        $currentQueueNumber = $currentQueue ? $currentQueue->nomor : 0;

        $nextQueues = [];
        foreach ($allQueues as $ruangan => $queues) {
            $nextQueue = NomorAntrian::whereDate('created_at', $today)
                ->where('status', 'sedang_antri')
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

        $ruangan_asal = $nomorAntrian->ruangan_asal;

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
        $today = Carbon::today()->toDateString();

        $allQueues = NomorAntrian::whereDate('created_at', $today)
            ->orderBy('nomor')
            ->get()
            ->groupBy('ruangan');

        $currentQueue = NomorAntrian::whereDate('created_at', $today)
            ->where('ruangan', 'apotik')
            ->where('status', 'sedang_dilayani')
            ->orderBy('nomor')
            ->first();

        $currentQueueNumber = $currentQueue ? $currentQueue->nomor : 0;

        $nextQueues = [];
        foreach ($allQueues as $ruangan => $queues) {
            $nextQueue = NomorAntrian::whereDate('created_at', $today)
                ->where('status', 'sedang_antri')
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

        $ruangan_asal = $nomorAntrian->ruangan_asal;

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
