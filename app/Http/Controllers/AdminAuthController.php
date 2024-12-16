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

        $visitorsLabels = Visitor::selectRaw('DATE_FORMAT(created_at, "%d %b") as formatted_date')
            ->whereDate('created_at', '>=', Carbon::now()->startOfMonth())
            ->whereDate('created_at', '<=', Carbon::now()->endOfMonth())
            ->groupBy('formatted_date')
            ->orderBy('formatted_date')
            ->pluck('formatted_date')
            ->toArray();

        $totalVisitorsThisMonth = Visitor::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();

        $queueData = RiwayatNomorAntrian::selectRaw('COUNT(*) as count, DATE(created_at) as date')
            ->whereDate('created_at', '>=', Carbon::now()->startOfMonth())
            ->whereDate('created_at', '<=', Carbon::now()->endOfMonth())
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count')
            ->toArray();

        $queueLabels = RiwayatNomorAntrian::selectRaw('DATE_FORMAT(created_at, "%d %b") as formatted_date')
            ->whereDate('created_at', '>=', Carbon::now()->startOfMonth())
            ->whereDate('created_at', '<=', Carbon::now()->endOfMonth())
            ->groupBy('formatted_date')
            ->orderBy('formatted_date')
            ->pluck('formatted_date')
            ->toArray();

        $queueRegistrationsCount = RiwayatNomorAntrian::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();

        $registrationData = User::selectRaw('COUNT(*) as count, DATE(created_at) as date')
            ->whereDate('created_at', '>=', Carbon::now()->startOfMonth())
            ->whereDate('created_at', '<=', Carbon::now()->endOfMonth())
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count')
            ->toArray();

        $registrationLabels = User::selectRaw('DATE_FORMAT(created_at, "%d %b") as formatted_date')
            ->whereDate('created_at', '>=', Carbon::now()->startOfMonth())
            ->whereDate('created_at', '<=', Carbon::now()->endOfMonth())
            ->groupBy('formatted_date')
            ->orderBy('formatted_date')
            ->pluck('formatted_date')
            ->toArray();

        $accountRegistrationsCount = User::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();

        $queueCompletedData = RiwayatNomorAntrian::selectRaw('COUNT(*) as count, DATE(created_at) as date')
            ->where('status', 'sudah_dilayani')
            ->whereDate('created_at', '>=', Carbon::now()->startOfMonth())
            ->whereDate('created_at', '<=', Carbon::now()->endOfMonth())
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count')
            ->toArray();

        $queueCompletedLabels = RiwayatNomorAntrian::selectRaw('DATE_FORMAT(created_at, "%d %b") as formatted_date')
            ->where('status', 'sudah_dilayani')
            ->whereDate('created_at', '>=', Carbon::now()->startOfMonth())
            ->whereDate('created_at', '<=', Carbon::now()->endOfMonth())
            ->groupBy('formatted_date')
            ->orderBy('formatted_date')
            ->pluck('formatted_date')
            ->toArray();

        $queueNotCompletedData = RiwayatNomorAntrian::selectRaw('COUNT(*) as count, DATE(created_at) as date')
            ->where('status', 'daftar_tunggu')
            ->whereDate('created_at', '>=', Carbon::now()->startOfMonth())
            ->whereDate('created_at', '<=', Carbon::now()->endOfMonth())
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count')
            ->toArray();

        $queueNotCompletedLabels = RiwayatNomorAntrian::selectRaw('DATE_FORMAT(created_at, "%d %b") as formatted_date')
            ->where('status', 'daftar_tunggu')
            ->whereDate('created_at', '>=', Carbon::now()->startOfMonth())
            ->whereDate('created_at', '<=', Carbon::now()->endOfMonth())
            ->groupBy('formatted_date')
            ->orderBy('formatted_date')
            ->pluck('formatted_date')
            ->toArray();

        $rooms = ['poli_umum', 'poli_gigi', 'poli_kia', 'poli_anak', 'lab', 'apotik'];
        $queueDataByRoom = [];
        $queueLabelsByRoom = [];
        $queueCompletedDataByRoom = [];
        $queueCompletedLabelsByRoom = [];
        $queueNotCompletedDataByRoom = [];
        $queueNotCompletedLabelsByRoom = [];

        foreach ($rooms as $room) {
            $this->processRoomData($room, 'all', $queueDataByRoom, $queueLabelsByRoom);
            $this->processRoomData($room, 'sudah_dilayani', $queueCompletedDataByRoom, $queueCompletedLabelsByRoom);
            $this->processRoomData($room, 'daftar_tunggu', $queueNotCompletedDataByRoom, $queueNotCompletedLabelsByRoom);
        }

        return view('secure.dashboard', [
            'visitorsData' => json_encode($visitorsData),
            'visitorsLabels' => json_encode($visitorsLabels),
            'queueData' => json_encode($queueData),
            'queueLabels' => json_encode($queueLabels),
            'registrationData' => json_encode($registrationData),
            'registrationLabels' => json_encode($registrationLabels),
            'queueRegistrationsCount' => $queueRegistrationsCount,
            'accountRegistrationsCount' => $accountRegistrationsCount,
            'totalVisitorsThisMonth' => $totalVisitorsThisMonth,
            'queueDataByRoom' => json_encode($queueDataByRoom),
            'queueLabelsByRoom' => json_encode($queueLabelsByRoom),
            'queueCompletedDataByRoom' => json_encode($queueCompletedDataByRoom),
            'queueCompletedLabelsByRoom' => json_encode($queueCompletedLabelsByRoom),
            'queueNotCompletedDataByRoom' => json_encode($queueNotCompletedDataByRoom),
            'queueNotCompletedLabelsByRoom' => json_encode($queueNotCompletedLabelsByRoom),
            'queueCompletedData' => json_encode($queueCompletedData),
            'queueCompletedLabels' => json_encode($queueCompletedLabels),
            'queueNotCompletedData' => json_encode($queueNotCompletedData),
            'queueNotCompletedLabels' => json_encode($queueNotCompletedLabels),
        ]);
    }

    private function processRoomData($room, $status, &$dataByRoom, &$labelsByRoom)
    {
        $query = RiwayatNomorAntrian::selectRaw('COUNT(*) as count, DATE_FORMAT(created_at, "%d %b") as formatted_date')
            ->where('ruangan', $room)
            ->whereDate('created_at', '>=', Carbon::now()->startOfMonth())
            ->whereDate('created_at', '<=', Carbon::now()->endOfMonth());

        if ($status !== 'all') {
            $query = $query->where('status', $status);
        }

        $data = $query->groupBy('formatted_date')
            ->orderBy('formatted_date')
            ->get()
            ->pluck('count', 'formatted_date')
            ->toArray();

        $dataByRoom[$room] = array_values($data);
        $labelsByRoom[$room] = array_keys($data);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    public function pindahKeRiwayat()
    {
        $nomorAntrian = NomorAntrian::all();
        foreach ($nomorAntrian as $antrian) {
            $riwayat = new RiwayatNomorAntrian([
                'nama' => $antrian->nama,
                'nik' => $antrian->nik,
                'ruangan' => $antrian->ruangan,
                'nomor' => $antrian->nomor,
                'created_at' => $antrian->created_at,
                'status' => $antrian->status,
                'waktu_dilayani' => null,
                'waktu_total_sistem' => $antrian->waktu_total_sistem,
                'riwayat_waktu' => null,
                'waktu' => null,
                'prioritas' => $antrian->prioritas,
                'user_id' => $antrian->user_id,
                'status_prioritas' => $antrian->status_prioritas,
                'ruangan_asal' => $antrian->ruangan_asal,
                'alasan_prioritas' => $antrian->alasan_prioritas,
                'status_pembayaran' => $antrian->status_pembayaran,
                'nomor_antrian_id' => $antrian->id
            ]);
            $riwayat->save();
            $antrian->delete();
        }
        return redirect()->route('pengaturan-antrian.index');
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
        $allQueues = NomorAntrian::with('user')
            ->where('status', '!=', 'sudah_dilayani')
            ->orderBy('nomor')
            ->get();

        return view('secure.prioritas', compact('allQueues'));
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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

        $nomorAntrian = NomorAntrian::find($request->nomor_antrian);

        $ruanganAsal = $nomorAntrian->ruangan_asal;

        $today = Carbon::now()->toDateString();

        $queueInOriginalRoom = NomorAntrian::where('ruangan_asal', $ruanganAsal)
            ->where('status', 'sedang_antri')
            ->whereDate('created_at', $today)
            ->orderBy('created_at')
            ->get();

        $found = false;
        $timeAdjustment = $this->getAverageServiceTime($ruanganAsal) * 60;

        foreach ($queueInOriginalRoom as $queue) {
            if ($queue->id == $nomorAntrian->id) {
                $found = true;
                continue;
            }
            if ($found) {
                $queue->waktu_total_sistem -= $timeAdjustment;
                $queue->save();
            }
        }

        $averageServiceTime = $this->getAverageServiceTime($ruanganTujuan) * 60;
        $currentQueueInNewRoom = NomorAntrian::where('ruangan', $ruanganTujuan)
            ->where('status', 'sedang_antri')
            ->whereDate('created_at', $today)
            ->orderBy('created_at')
            ->get();

        $nomorAntrian->ruangan = $ruanganTujuan;
        $nomorAntrian->waktu_total_sistem = $currentQueueInNewRoom->isEmpty() ? $averageServiceTime : $currentQueueInNewRoom->last()->waktu_total_sistem + $averageServiceTime;

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
            'poli_umum' => 'A',
            'poli_gigi' => 'B',
            'poli_kia' => 'C',
            'poli_anak' => 'D',
            'lab' => 'LAB',
            'apotik' => 'APT',
        ];
        return isset($map[$ruangan]) ? $map[$ruangan] : '';
    }

    private function ruanganToNumericInt($ruangan)
    {
        $map = [
            'poli_umum' => 1,
            'poli_gigi' => 2,
            'poli_kia' => 3,
            'poli_anak' => 4,
            'lab' => 5,
            'apotik' => 6,
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
        $lastNumber = intval(preg_replace('/[^0-9]/', '', substr($existingNumber, strrpos($existingNumber, '_') + 1)));
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
        $nomorAntrian->status_prioritas++;
        $nomorAntrian->save();

        $today = Carbon::now()->toDateString();
        $allActiveQueues = NomorAntrian::where('ruangan', $nomorAntrian->ruangan)
            ->where('status', 'sedang_antri')
            ->whereDate('created_at', $today)
            ->orderBy('created_at')
            ->get();

        $averageServiceTime = $this->getAverageServiceTime($nomorAntrian->ruangan) * 60;
        $totalWaktuTunggu = 0;
        foreach ($allActiveQueues as $queue) {
            $queuePriorityFactor = 1 / max(1, $queue->status_prioritas);
            $queueTimeAdjustment = $averageServiceTime * $queuePriorityFactor;
            $totalWaktuTunggu += $queueTimeAdjustment;
            $queue->waktu_total_sistem = $totalWaktuTunggu;
            $queue->save();
        }

        return redirect()->back()->with('success', 'Nomor antrian ' . $nomorAntrian->nomor . ' dipanggil kembali.');
    }
    public function pindahkanKeDaftarTunggu(Request $request)
    {
        $request->validate([
            'nomor_antrian' => 'required|exists:nomorantrian,id',
        ]);

        $nomorAntrian = NomorAntrian::find($request->nomor_antrian);
        $nomorAntrian->status = 'daftar_tunggu';
        $nomorAntrian->save();

        $today = Carbon::now()->toDateString();
        $allActiveQueues = NomorAntrian::where('ruangan', $nomorAntrian->ruangan)
            ->where('status', 'sedang_antri')
            ->whereDate('created_at', $today)
            ->orderBy('created_at')
            ->get();

        $averageServiceTime = $this->getAverageServiceTime($nomorAntrian->ruangan) * 60;
        $totalWaktuTunggu = 0;
        foreach ($allActiveQueues as $queue) {
            $totalWaktuTunggu += $averageServiceTime;
            $queue->waktu_total_sistem = $totalWaktuTunggu;
            $queue->save();
        }

        return redirect()->back()->with('success', 'Nomor antrian berhasil dipindahkan ke Daftar Tunggu.');
    }

    public function berikanPrioritas(Request $request)
    {
        $request->validate([
            'nomor_antrian' => 'required|exists:nomorantrian,id',
            'alasan_prioritas' => 'required|string|max:255',
        ]);

        $nomorAntrian = NomorAntrian::find($request->nomor_antrian);
        $ruangan = $nomorAntrian->ruangan;
        $today = Carbon::now()->toDateString();
        $averageServiceTime = $this->getAverageServiceTime($ruangan) * 60;

        $nomorAntrian->prioritas = 'didahulukan';
        $nomorAntrian->status_prioritas = 20;
        $nomorAntrian->alasan_prioritas = $request->alasan_prioritas;
        $nomorAntrian->save();

        $allQueuesToday = NomorAntrian::where('ruangan', $ruangan)
            ->whereDate('created_at', $today)
            ->orderBy('status_prioritas', 'desc')
            ->orderBy('created_at')
            ->get();

        $newWaitTime = 0;
        foreach ($allQueuesToday as $queue) {
            if ($newWaitTime == 0) {
                $queue->waktu_total_sistem = $averageServiceTime;
                $newWaitTime = $averageServiceTime;
            } else {
                $newWaitTime += $averageServiceTime;
                $queue->waktu_total_sistem = $newWaitTime;
            }
            $queue->save();
        }

        return redirect()->back()->with('success', 'Nomor antrian ' . $nomorAntrian->nomor . ' telah diberikan prioritas dengan alasan: ' . $request->alasan_prioritas);
    }

    private function getAverageServiceTime($ruangan)
    {
        $serviceTimes = [
            'poli_umum' => 5,
            'poli_gigi' => 15,
            'poli_kia' => 10,
            'poli_anak' => 10,
            'lab' => 15,
            'apotik' => 5,
        ];
        return $serviceTimes[$ruangan] ?? 5;
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
            ->orderByRaw("CASE WHEN status = 'sudah_dilayani' THEN 1 ELSE 0 END, status_prioritas DESC, nomor")
            ->orderBy('nomor')
            ->get()
            ->groupBy('ruangan');

        $currentQueue = NomorAntrian::whereDate('created_at', $today)
            ->where('ruangan', 'poli_umum')
            ->where(function ($query) {
                $query->where('status', 'sedang_dilayani')
                    ->orWhere('status', 'like', 'sedang_dilayani_%');
            })
            ->orderBy('nomor')
            ->first();

        $user = null;

        if ($currentQueue) {
            $user = User::find($currentQueue->user_id);
        }

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
            'user' => $user
        ]);
    }

    public function startQueuePoliUmum()
    {
        $ruangan = 'poli_umum';

        $firstQueue = NomorAntrian::where('ruangan', $ruangan)
            ->where('status', 'like', 'sedang_antri%')
            ->orderBy('status_prioritas', 'desc')
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

        $today = Carbon::now()->toDateString();
        $allQueues = NomorAntrian::where('ruangan', 'poli_umum')
            ->whereDate('created_at', $today)
            ->where('status', '!=', 'sudah_dilayani')
            ->orderBy('created_at')
            ->get();

        $averageServiceTime = $this->getAverageServiceTime('poli_umum') * 60;
        $newWaitTime = 0;
        foreach ($allQueues as $queue) {
            if ($newWaitTime == 0) {
                $queue->waktu_total_sistem = $averageServiceTime;
                $newWaitTime = $averageServiceTime;
            } else {
                $newWaitTime += $averageServiceTime;
                $queue->waktu_total_sistem = $newWaitTime;
            }
            $queue->save();
        }

        return redirect()->back()->with('success', 'Antrian telah selesai dilayani.');
    }


    public function showGigiUmumPage()
    {
        $today = Carbon::today()->toDateString();

        $allQueues = NomorAntrian::whereDate('created_at', $today)
            ->orderByRaw("CASE WHEN status = 'sudah_dilayani' THEN 1 ELSE 0 END, status_prioritas DESC, nomor")
            ->orderBy('status_prioritas', 'desc')
            ->orderBy('nomor')
            ->get()
            ->groupBy('ruangan');

        $currentQueue = NomorAntrian::whereDate('created_at', $today)
            ->where('ruangan', 'poli_gigi')
            ->where(function ($query) {
                $query->where('status', 'sedang_dilayani')
                    ->orWhere('status', 'like', 'sedang_dilayani_%');
            })
            ->orderBy('nomor')
            ->first();

        $user = null;

        if ($currentQueue) {
            $user = User::find($currentQueue->user_id);
        }

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
            'user' => $user,
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

        $today = Carbon::now()->toDateString();
        $allQueues = NomorAntrian::where('ruangan', 'poli_gigi')
            ->whereDate('created_at', $today)
            ->where('status', '!=', 'sudah_dilayani')
            ->orderBy('created_at')
            ->get();

        $averageServiceTime = $this->getAverageServiceTime('poli_gigi') * 60;
        $newWaitTime = 0;
        foreach ($allQueues as $queue) {
            if ($newWaitTime == 0) {
                $queue->waktu_total_sistem = $averageServiceTime;
                $newWaitTime = $averageServiceTime;
            } else {
                $newWaitTime += $averageServiceTime;
                $queue->waktu_total_sistem = $newWaitTime;
            }
            $queue->save();
        }

        return redirect()->back()->with('success', 'Antrian telah selesai dilayani.');
    }

    public function startQueuePoliGigi()
    {
        $ruangan = 'poli_gigi';

        $firstQueue = NomorAntrian::where('ruangan', $ruangan)
            ->where('status', 'like', 'sedang_antri%')
            ->orderBy('status_prioritas', 'desc')
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
            ->orderByRaw("CASE WHEN status = 'sudah_dilayani' THEN 1 ELSE 0 END, status_prioritas DESC, nomor")
            ->orderBy('nomor')
            ->get()
            ->groupBy('ruangan');

        $currentQueue = NomorAntrian::whereDate('created_at', $today)
            ->where('ruangan', 'poli_kia')
            ->where(function ($query) {
                $query->where('status', 'sedang_dilayani')
                    ->orWhere('status', 'like', 'sedang_dilayani_%');
            })
            ->orderBy('nomor')
            ->first();

        $user = null;

        if ($currentQueue) {
            $user = User::find($currentQueue->user_id);
        }

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
            'user' => $user,
        ]);
    }

    public function startQueuePoliKia()
    {
        $ruangan = 'poli_kia';

        $firstQueue = NomorAntrian::where('ruangan', $ruangan)
            ->where('status', 'like', 'sedang_antri%')
            ->orderBy('status_prioritas', 'desc')
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

        $today = Carbon::now()->toDateString();
        $allQueues = NomorAntrian::where('ruangan', 'poli_kia')
            ->whereDate('created_at', $today)
            ->where('status', '!=', 'sudah_dilayani')
            ->orderBy('created_at')
            ->get();

        $averageServiceTime = $this->getAverageServiceTime('poli_kia') * 60;
        $newWaitTime = 0;
        foreach ($allQueues as $queue) {
            if ($newWaitTime == 0) {
                $queue->waktu_total_sistem = $averageServiceTime;
                $newWaitTime = $averageServiceTime;
            } else {
                $newWaitTime += $averageServiceTime;
                $queue->waktu_total_sistem = $newWaitTime;
            }
            $queue->save();
        }

        return redirect()->back()->with('success', 'Antrian telah selesai dilayani.');
    }

    public function showAnakUmumPage()
    {
        $today = Carbon::today()->toDateString();

        $allQueues = NomorAntrian::whereDate('created_at', $today)
            ->orderByRaw("CASE WHEN status = 'sudah_dilayani' THEN 1 ELSE 0 END, status_prioritas DESC, nomor")
            ->orderBy('nomor')
            ->get()
            ->groupBy('ruangan');

        $currentQueue = NomorAntrian::whereDate('created_at', $today)
            ->where('ruangan', 'poli_anak')
            ->where(function ($query) {
                $query->where('status', 'sedang_dilayani')
                    ->orWhere('status', 'like', 'sedang_dilayani_%');
            })
            ->orderBy('nomor')
            ->first();

        $user = null;

        if ($currentQueue) {
            $user = User::find($currentQueue->user_id);
        }

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
            'user' => $user,
        ]);
    }

    public function startQueuePoliAnak()
    {
        $ruangan = 'poli_anak';

        $firstQueue = NomorAntrian::where('ruangan', $ruangan)
            ->where('status', 'like', 'sedang_antri%')
            ->orderBy('status_prioritas', 'desc')
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

        $today = Carbon::now()->toDateString();
        $allQueues = NomorAntrian::where('ruangan', 'poli_anak')
            ->whereDate('created_at', $today)
            ->where('status', '!=', 'sudah_dilayani')
            ->orderBy('created_at')
            ->get();

        $averageServiceTime = $this->getAverageServiceTime('poli_anak') * 60;
        $newWaitTime = 0;
        foreach ($allQueues as $queue) {
            if ($newWaitTime == 0) {
                $queue->waktu_total_sistem = $averageServiceTime;
                $newWaitTime = $averageServiceTime;
            } else {
                $newWaitTime += $averageServiceTime;
                $queue->waktu_total_sistem = $newWaitTime;
            }
            $queue->save();
        }

        return redirect()->back()->with('success', 'Antrian telah selesai dilayani.');
    }

    public function showLabUmumPage()
    {
        $today = Carbon::today()->toDateString();

        $allQueues = NomorAntrian::whereDate('created_at', $today)
            ->orderByRaw("CASE WHEN status = 'sudah_dilayani' THEN 1 ELSE 0 END, status_prioritas DESC, nomor")
            ->orderBy('nomor')
            ->get()
            ->groupBy('ruangan');

        $currentQueue = NomorAntrian::whereDate('created_at', $today)
            ->where('ruangan', 'lab')
            ->where(function ($query) {
                $query->where('status', 'sedang_dilayani')
                    ->orWhere('status', 'like', 'sedang_dilayani_%');
            })
            ->orderBy('nomor')
            ->first();

        $user = null;

        if ($currentQueue) {
            $user = User::find($currentQueue->user_id);
        }

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
            'user' => $user,
        ]);
    }

    public function startQueueLab()
    {
        $ruangan = 'lab';

        $firstQueue = NomorAntrian::where('ruangan', $ruangan)
            ->where('status', 'like', 'sedang_antri%')
            ->orderBy('status_prioritas', 'desc')
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

        $today = Carbon::now()->toDateString();
        $allQueues = NomorAntrian::where('ruangan', 'lab')
            ->whereDate('created_at', $today)
            ->where('status', '!=', 'sudah_dilayani')
            ->orderBy('created_at')
            ->get();

        $averageServiceTime = $this->getAverageServiceTime('lab') * 60;
        $newWaitTime = 0;
        foreach ($allQueues as $queue) {
            if ($newWaitTime == 0) {
                $queue->waktu_total_sistem = $averageServiceTime;
                $newWaitTime = $averageServiceTime;
            } else {
                $newWaitTime += $averageServiceTime;
                $queue->waktu_total_sistem = $newWaitTime;
            }
            $queue->save();
        }

        return redirect()->back()->with('success', 'Antrian telah selesai dilayani.');
    }

    public function showApotikUmumPage()
    {
        $today = Carbon::today()->toDateString();

        $allQueues = NomorAntrian::whereDate('created_at', $today)
            ->orderByRaw("CASE WHEN status = 'sudah_dilayani' THEN 1 ELSE 0 END, status_prioritas DESC, nomor")
            ->orderBy('nomor')
            ->get()
            ->groupBy('ruangan');

        $currentQueue = NomorAntrian::whereDate('created_at', $today)
            ->where('ruangan', 'apotik')
            ->where(function ($query) {
                $query->where('status', 'sedang_dilayani')
                    ->orWhere('status', 'like', 'sedang_dilayani_%');
            })
            ->orderBy('nomor')
            ->first();

        $user = null;

        if ($currentQueue) {
            $user = User::find($currentQueue->user_id);
        }

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
            'user' => $user,
        ]);
    }

    public function startQueueApotik()
    {
        $ruangan = 'apotik';

        $firstQueue = NomorAntrian::where('ruangan', $ruangan)
            ->where('status', 'like', 'sedang_antri%')
            ->orderBy('status_prioritas', 'desc')
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

        $today = Carbon::now()->toDateString();
        $allQueues = NomorAntrian::where('ruangan', 'apotik')
            ->whereDate('created_at', $today)
            ->where('status', '!=', 'sudah_dilayani')
            ->orderBy('created_at')
            ->get();

        $averageServiceTime = $this->getAverageServiceTime('apotik') * 60;
        $newWaitTime = 0;
        foreach ($allQueues as $queue) {
            if ($newWaitTime == 0) {
                $queue->waktu_total_sistem = $averageServiceTime;
                $newWaitTime = $averageServiceTime;
            } else {
                $newWaitTime += $averageServiceTime;
                $queue->waktu_total_sistem = $newWaitTime;
            }
            $queue->save();
        }

        return redirect()->back()->with('success', 'Antrian telah selesai dilayani.');
    }
}
