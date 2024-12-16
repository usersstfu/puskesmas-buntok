<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NomorAntrian;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\AntrianSetting;
use App\Models\User;
use Phpml\Dataset\CsvDataset;
use Phpml\Regression\LeastSquares;
use Phpml\ModelManager;
use League\Csv\Reader;
use App\Models\RiwayatNomorAntrian;

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
        $nomorAntrian->ruangan_asal = $ruangan;
        $nomorAntrian->user_id = $user->id;
        $nomorAntrian->status_prioritas = 1;

        try {
            $birthdate = Carbon::createFromFormat('Y-m-d', $user->birthdate);
            $usia = $birthdate->diffInYears(Carbon::now());
            if ($usia >= 60) {
                $nomorAntrian->status_prioritas = 10;
                $prioritas = 'Usia';
            } else {
                $nomorAntrian->status_prioritas = 1;
                $prioritas = 'Umum';
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Invalid birthdate format. Please enter the birthdate in the format YYYY-MM-DD.');
        }

        if ($user->bpjs_card) {
            $nomorAntrian->status_pembayaran = 'BPJS';
        } else {
            $nomorAntrian->status_pembayaran = 'Belum Lunas';
        }

        $kodeRuangan = $this->getKodeRuangan($ruangan);
        $averageServiceTime = $this->getAverageServiceTime($ruangan) * 60;

        $lastQueueToday = NomorAntrian::where('ruangan_asal', $ruangan)
            ->whereDate('created_at', $today)
            ->orderBy('created_at', 'desc')
            ->first();

        $lastQueueNumber = $lastQueueToday ? intval(substr($lastQueueToday->nomor, strlen($kodeRuangan))) : 0;
        $newQueueNumber = $lastQueueNumber + 1;

        $nomorAntrian->nomor = $kodeRuangan . $newQueueNumber;
        $nomorAntrian->prioritas = $prioritas;

        $allQueuesToday = NomorAntrian::where('ruangan', $ruangan)
            ->where('status', 'sedang_antri')
            ->whereDate('created_at', $today)
            ->orderBy('nomor')
            ->get();
            
        $adjustedWaitTime = $averageServiceTime;
        foreach ($allQueuesToday as $queue) {
            if ($nomorAntrian->status_prioritas > $queue->status_prioritas) {
                $queue->waktu_total_sistem += $averageServiceTime;
                $queue->save();
            } else {
                $adjustedWaitTime += $averageServiceTime;
            }
        }
        
        $nomorAntrian->waktu_total_sistem = $adjustedWaitTime;
        $nomorAntrian->save();

        return redirect()->route('lihat-antrian')->with('success', 'Nomor antrian Anda telah didaftarkan.');
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

    private function getKodeRuangan($ruangan)
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
                'status' => 'sedang_antri',
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

    public function trainModel()
    {
        $csvFile = public_path('data_antrian_newbie.csv');
        $handle = fopen($csvFile, 'r');

        if ($handle === false) {
            return response()->json(['error' => 'Failed to open CSV file'], 400);
        }

        $samples = [];
        $labels = [];

        while (($row = fgetcsv($handle)) !== false) {
            $jsonData = $row[count($row) - 2];
            $data = json_decode($jsonData, true);

            if ($data === null) {
                continue;
            }

            $samples[] = [
                intval(substr($row[0], 1)),
                intval($this->ruanganToNumeric($row[1])),
                intval($row[2]),
            ];
            $labels[] = $data;
        }

        fclose($handle);

        $regression = new LeastSquares();
        $regression->train($samples, $labels);

        $modelPath = public_path('model/antrianModel.pkl');
        $modelManager = new ModelManager();
        $modelManager->saveToFile($regression, $modelPath);

        return response()->json(['message' => 'Model trained successfully']);
    }

    public function predict(Request $request)
    {
        $nomor = intval(substr($request->input('nomor'), 1));
        $ruangan = intval($this->ruanganToNumeric($request->input('ruangan')));
        $status_prioritas = intval($request->input('status_prioritas'));

        $modelPath = public_path('model/antrianModel.pkl');

        if (!file_exists($modelPath)) {
            return response()->json(['error' => 'Model file not found'], 404);
        }

        $modelManager = new ModelManager();
        $regression = $modelManager->restoreFromFile(($modelPath));

        $prediksi = $regression->predict([[$nomor, $ruangan, $status_prioritas]]);

        return response()->json(['predicted_wait_time' => $prediksi]);
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
}
