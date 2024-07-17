<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NomorAntrian;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SimulasiController extends Controller
{
    private function generateRandomName()
    {
        $names = ['John', 'Jane', 'Alice', 'Bob', 'Charlie', 'Emma', 'Oliver', 'Sophia', 'James', 'Emily'];
        return $names[array_rand($names)];
    }

    public function eksporDataAntrianKeCsv()
    {
        $antrian = NomorAntrian::all();

        $filename = "data_antrian_baru.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, [
            'nomor', 'ruangan', 'status_prioritas', 'nama', 'nik',
            'waktu', 'status', 'created_at', 'updated_at',
            'waktu_dilayani', 'waktu_total_sistem', 'riwayat_waktu'
        ]);

        foreach ($antrian as $row) {
            fputcsv($handle, [
                $row->nomor,
                $row->ruangan,
                $row->status_prioritas,
                $row->nama,
                $row->nik,
                $row->waktu,
                $row->status,
                $row->created_at->format('Y-m-d H:i:s'),
                $row->updated_at->format('Y-m-d H:i:s'),
                $row->waktu_dilayani,
                $row->waktu_total_sistem,
                json_encode($row->riwayat_waktu)
            ]);
        }

        fclose($handle);

        return response()->download($filename);
    }


    private function generateRandomNIK()
    {
        $nik = '';
        for ($i = 0; $i < 16; $i++) {
            $nik .= mt_rand(0, 9);
        }
        return $nik;
    }

    public function tampilkanDataAntrian(Request $request)
    {
        $tanggal = $request->input('tanggal');

        if ($tanggal) {
            $antrian = NomorAntrian::whereDate('created_at', $tanggal)->orderBy('nomor')->get();
        } else {
            $antrian = NomorAntrian::orderBy('nomor')->get();
        }

        $jumlahSedangAntri = NomorAntrian::where('status', 'sedang_antri')->count();
        $jumlahSedangDilayani = NomorAntrian::where('status', 'sedang_dilayani')->count();

        $availableDates = NomorAntrian::select(DB::raw('DATE(created_at) as tanggal'))
            ->distinct()
            ->orderBy('tanggal', 'asc')
            ->get()
            ->pluck('tanggal')
            ->toArray();

        return view('simulasi.antrian', compact('antrian', 'jumlahSedangAntri', 'jumlahSedangDilayani', 'availableDates', 'tanggal'));
    }

    private function generateNomor($ruangan, $nomor)
    {
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
        return $kodeRuangan . $nomor;
    }

    private function getDurasiWaktu($ruangan)
    {
        switch ($ruangan) {
            case 'poli_umum':
                return mt_rand(300, 600);
            case 'poli_anak':
            case 'poli_kia':
                return mt_rand(480, 900);
            case 'poli_gigi':
                return mt_rand(600, 1200);
            case 'lab':
                return mt_rand(900, 1800);
            case 'apotik':
                return mt_rand(180, 480);
            default:
                return 600;
        }
    }

    public function generateNomorAntrian()
    {
        $lastAntrian = NomorAntrian::orderBy('created_at', 'desc')->first();
        $currentDate = $lastAntrian ? Carbon::parse($lastAntrian->created_at)->addDay()->format('Y-m-d') : Carbon::now()->format('Y-m-d');

        $ruanganList = [
            'poli_umum' => ['min' => 60, 'max' => 80, 'prioritas_usia' => [5, 10], 'prioritas_didahulukan' => [0, 5]],
            'poli_gigi' => ['min' => 5, 'max' => 10, 'prioritas_usia' => [2, 3], 'prioritas_didahulukan' => [0, 2]],
            'poli_kia'  => ['min' => 10, 'max' => 15, 'prioritas_usia' => [3, 5], 'prioritas_didahulukan' => [0, 3]],
            'poli_anak' => ['min' => 10, 'max' => 15, 'prioritas_usia' => [3, 5], 'prioritas_didahulukan' => [0, 3]],
            'lab'       => ['min' => 2, 'max' => 5, 'prioritas_usia' => [1, 3], 'prioritas_didahulukan' => [0, 2]],
            'apotik'    => ['min' => 5, 'max' => 8, 'prioritas_usia' => [1, 3], 'prioritas_didahulukan' => [0, 2]],
        ];

        foreach ($ruanganList as $ruangan => $details) {
            $jumlahAntrian = mt_rand($details['min'], $details['max']);
            $prioritasUsiaCount = mt_rand($details['prioritas_usia'][0], $details['prioritas_usia'][1]);
            $prioritasDidahulukanCount = mt_rand($details['prioritas_didahulukan'][0], $details['prioritas_didahulukan'][1]);
            for ($i = 1; $i <= $jumlahAntrian; $i++) {
                $nomorAntrian = new NomorAntrian();
                $nomorAntrian->nomor = $this->generateNomor($ruangan, $i);
                $nomorAntrian->ruangan = $ruangan;
                $nomorAntrian->nama = $this->generateRandomName();
                $nomorAntrian->nik = $this->generateRandomNIK();
                $nomorAntrian->waktu = 0;
                $nomorAntrian->status = 'sedang_antri';
                $nomorAntrian->created_at = $currentDate;
                $nomorAntrian->updated_at = $currentDate;
                if ($i <= $prioritasUsiaCount) {
                    $nomorAntrian->status_prioritas = 10;
                    $nomorAntrian->prioritas = 'Usia';
                } elseif ($i <= ($prioritasUsiaCount + $prioritasDidahulukanCount)) {
                    $nomorAntrian->status_prioritas = 20;
                    $nomorAntrian->prioritas = 'Didahulukan';
                } else {
                    $nomorAntrian->status_prioritas = 1;
                    $nomorAntrian->prioritas = 'Umum';
                }
                $nomorAntrian->save();

                session()->put("ruangan_asal_{$nomorAntrian->id}", $ruangan);
            }
        }

        $this->startQueue('poli_umum');
        $this->startQueue('poli_anak');
        $this->startQueue('poli_kia');
        $this->startQueue('poli_gigi');
        $this->startQueue('lab');
        $this->startQueue('apotik');

        return redirect()->route('tampilkan-antrian')->with('success', 'Nomor antrian telah berhasil dibuat.');
    }

    public function updateWaktuAntrian()
    {
        $antrian = NomorAntrian::orderBy('nomor')->get();

        foreach ($antrian as $dataAntrian) {
            if ($dataAntrian->status === 'sedang_antri') {
                $waktu_tunggu = $this->calculateWaitingTime($dataAntrian);
                $dataAntrian->waktu = $waktu_tunggu;
            } elseif ($dataAntrian->status === 'sedang_dilayani') {
                $durasi_waktu = $this->getDurasiWaktu($dataAntrian->ruangan);
                $dataAntrian->waktu_dilayani = $durasi_waktu;

                if ($dataAntrian->waktu_dilayani >= $durasi_waktu) {
                    $this->handleRuanganTransition($dataAntrian, $durasi_waktu);
                }
            }
            $dataAntrian->save();
        }

        $ruanganList = ['poli_umum', 'poli_anak', 'poli_kia', 'poli_gigi', 'lab', 'apotik'];
        foreach ($ruanganList as $ruangan) {
            $this->startQueue($ruangan);
        }

        return response()->json(['success' => 'Waktu antrian telah diperbarui']);
    }

    private function calculateWaitingTime($dataAntrian)
    {
        $previousAntrians = NomorAntrian::where('ruangan', $dataAntrian->ruangan)
            ->where('nomor', '<', $dataAntrian->nomor)
            ->where('status', '!=', 'sedang_antri')
            ->get();

        $totalWaitingTime = 0;

        foreach ($previousAntrians as $antrian) {
            $totalWaitingTime += $antrian->waktu_dilayani;
        }

        return $totalWaitingTime;
    }

    private function handleRuanganTransition($dataAntrian, $durasi_waktu)
    {
        $ruanganAsal = session()->get("ruangan_asal_{$dataAntrian->id}");

        $this->saveTransitionHistory($dataAntrian);

        if (strpos($dataAntrian->ruangan, 'poli_') === 0) {
            if (!session()->has("returned_from_lab_{$dataAntrian->id}")) {
                $dataAntrian->ruangan = 'lab';
            } else {
                $dataAntrian->ruangan = 'apotik';
                session()->forget("returned_from_lab_{$dataAntrian->id}"); 
            }
        } elseif ($dataAntrian->ruangan === 'lab') {
            if ($ruanganAsal !== 'lab') {
                session()->put("returned_from_lab_{$dataAntrian->id}", true);
                $dataAntrian->ruangan = $ruanganAsal;
            } else {
                $dataAntrian->status = 'sudah_dilayani';
                $this->updateWaktuTotalSistem($dataAntrian);
                $dataAntrian->ruangan = $ruanganAsal;
            }
        } elseif ($dataAntrian->ruangan === 'apotik') {
            $dataAntrian->status = 'sudah_dilayani';
            $this->updateWaktuTotalSistem($dataAntrian);
            $dataAntrian->ruangan = $ruanganAsal;
        }

        $dataAntrian->status_prioritas += 1;

        $dataAntrian->waktu_dilayani = 0;
        $dataAntrian->updated_at = now();
        $dataAntrian->save();

        if ($dataAntrian->status !== 'sudah_dilayani') {
            $this->startQueue($dataAntrian->ruangan);
        } else {
            $this->returnToOriginalRoom($dataAntrian);
        }
    }

    private function returnToOriginalRoom($dataAntrian)
    {
        $ruanganAsal = session()->get("ruangan_asal_{$dataAntrian->id}");
        $dataAntrian->ruangan = $ruanganAsal;
        $dataAntrian->status = 'sudah_dilayani';
        $dataAntrian->save();
    }


    private function updateWaktuTotalSistem($dataAntrian)
    {
        $riwayat_waktu = $dataAntrian->riwayat_waktu;
        $total_waktu = 0;

        if (!empty($riwayat_waktu)) {
            foreach ($riwayat_waktu as $riwayat) {
                $total_waktu += $riwayat['waktu'];
                $total_waktu += $riwayat['waktu_dilayani'];
            }
        }

        $dataAntrian->waktu_total_sistem = $total_waktu;
        $dataAntrian->save();
    }

    private function saveTransitionHistory($dataAntrian)
    {
        $currentHistory = $dataAntrian->riwayat_waktu ?? [];

        $transition = [
            'waktu' => $dataAntrian->waktu,
            'waktu_dilayani' => $dataAntrian->waktu_dilayani,
            'ruangan' => $dataAntrian->ruangan,
            'updated_at' => $dataAntrian->updated_at,
        ];

        $currentHistory[] = $transition;

        $dataAntrian->riwayat_waktu = $currentHistory;
        $dataAntrian->waktu = 0;
        $dataAntrian->save();
    }

    private function startQueue($ruangan)
    {
        $currentlyServing = NomorAntrian::where('ruangan', $ruangan)
            ->where('status', 'sedang_dilayani')
            ->exists();

        if (!$currentlyServing) {
            $nextQueue = NomorAntrian::where('ruangan', $ruangan)
                ->where('status', 'sedang_antri')
                ->orderBy('status_prioritas', 'desc') 
                ->orderBy('updated_at') 
                ->first();

            if ($nextQueue) {
                $nextQueue->update([
                    'status' => 'sedang_dilayani',
                    'waktu_dilayani' => 0,
                    'start_served_at' => now()
                ]);

                $durasi_waktu = $this->getDurasiWaktu($ruangan);
                $waktu_selesai_dilayani = now()->addSeconds($durasi_waktu);

                session(['waktu_selesai_dilayani' => $waktu_selesai_dilayani]);
            }
        }
    }
}
