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

        $filename = "data_antrian.csv";
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
            'poli_umum' => ['min' => 60, 'max' => 80],
            'poli_gigi' => ['min' => 5, 'max' => 10],
            'poli_kia'  => ['min' => 10, 'max' => 15],
            'poli_anak' => ['min' => 10, 'max' => 15],
            'lab'       => ['min' => 2, 'max' => 5],
            'apotik'    => ['min' => 5, 'max' => 8],
        ];

        foreach ($ruanganList as $ruangan => $range) {
            $jumlahAntrian = mt_rand($range['min'], $range['max']);
            for ($i = 1; $i <= $jumlahAntrian; $i++) {
                $nomorAntrian = new NomorAntrian();
                $nomorAntrian->nomor = $this->generateNomor($ruangan, $i);
                $nomorAntrian->ruangan = $ruangan;
                $nomorAntrian->status_prioritas = 1;
                $nomorAntrian->nama = $this->generateRandomName();
                $nomorAntrian->nik = $this->generateRandomNIK();
                $nomorAntrian->waktu = 0;
                $nomorAntrian->status = 'sedang_antri';
                $nomorAntrian->created_at = $currentDate;
                $nomorAntrian->updated_at = $currentDate;
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
        $antrian = NomorAntrian::orderBy('nomor')->get(); // Pastikan urutan antrian berdasarkan nomor

        foreach ($antrian as $dataAntrian) {
            if ($dataAntrian->status === 'sedang_antri') {
                // Hitung waktu tunggu berdasarkan waktu dilayani antrian sebelumnya
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
        // Dapatkan semua antrian sebelum antrian saat ini di ruangan yang sama
        $previousAntrians = NomorAntrian::where('ruangan', $dataAntrian->ruangan)
            ->where('nomor', '<', $dataAntrian->nomor)
            ->where('status', '!=', 'sedang_antri') // Hanya hitung antrian yang sudah atau sedang dilayani
            ->get();

        $totalWaitingTime = 0;

        foreach ($previousAntrians as $antrian) {
            // Tambahkan waktu dilayani untuk setiap antrian sebelumnya
            $totalWaitingTime += $antrian->waktu_dilayani;
        }

        return $totalWaitingTime;
    }

    private function handleRuanganTransition($dataAntrian, $durasi_waktu)
    {
        $ruanganAsal = session()->get("ruangan_asal_{$dataAntrian->id}");

        $this->saveTransitionHistory($dataAntrian);

        if (strpos($dataAntrian->ruangan, 'poli_') === 0) {
            if ($dataAntrian->status_prioritas === 1) {
                $dataAntrian->status_prioritas++;
                $dataAntrian->ruangan = 'lab';
                $dataAntrian->status = 'sedang_antri';
            } elseif ($dataAntrian->status_prioritas === 3) {
                $dataAntrian->status_prioritas++;
                $dataAntrian->ruangan = 'apotik';
                $dataAntrian->status = 'sedang_antri';
            }
        } elseif ($dataAntrian->ruangan === 'lab' || $dataAntrian->ruangan === 'apotik') {
            if ($dataAntrian->ruangan === 'lab') {
                if ($ruanganAsal === 'lab') {
                    $dataAntrian->status = 'sudah_dilayani';
                    $this->updateWaktuTotalSistem($dataAntrian);
                } else {
                    $dataAntrian->status_prioritas++;
                    $dataAntrian->ruangan = $ruanganAsal;
                    $dataAntrian->status = 'sedang_antri';
                }
            } elseif ($dataAntrian->ruangan === 'apotik') {
                if ($ruanganAsal === 'apotik') {
                    $dataAntrian->status = 'sudah_dilayani';
                    $this->updateWaktuTotalSistem($dataAntrian);
                } else {
                    if ($dataAntrian->status_prioritas === 2 || $dataAntrian->status_prioritas === 4) {
                        $dataAntrian->status = 'sudah_dilayani';
                        $dataAntrian->ruangan = $ruanganAsal;
                        $this->updateWaktuTotalSistem($dataAntrian);
                    } else {
                        $dataAntrian->status_prioritas++;
                        $dataAntrian->ruangan = $ruanganAsal;
                        $dataAntrian->status = 'sedang_antri';
                    }
                }
            }
        }

        $dataAntrian->waktu_dilayani = 0;
        $dataAntrian->updated_at = now();
        $dataAntrian->save();

        $this->startQueue($dataAntrian->ruangan);

        if (!is_null($ruanganAsal)) {
            $this->startQueue($ruanganAsal);
        }
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
        // Cek apakah ada antrian yang sedang dilayani di ruangan tertentu
        $currentlyServing = NomorAntrian::where('ruangan', $ruangan)
            ->where('status', 'sedang_dilayani')
            ->exists();

        if (!$currentlyServing) {
            // Pilih antrian berikutnya yang sedang dalam status 'sedang_antri' berdasarkan status_prioritas dan updated_at
            $nextQueue = NomorAntrian::where('ruangan', $ruangan)
                ->where('status', 'sedang_antri')
                ->orderBy('status_prioritas', 'desc') // Urutkan berdasarkan status_prioritas tertinggi
                ->orderBy('updated_at') // Urutkan berdasarkan waktu pembaruan terawal
                ->first();

            if ($nextQueue) {
                // Perbarui status antrian menjadi 'sedang_dilayani' dan waktu_dilayani menjadi 0
                $nextQueue->update([
                    'status' => 'sedang_dilayani',
                    'waktu_dilayani' => 0,
                    'start_served_at' => now() // Simpan waktu mulai dilayani
                ]);

                // Hitung waktu selesai dilayani berdasarkan durasi waktu yang diperoleh dari fungsi getDurasiWaktu($ruangan)
                $durasi_waktu = $this->getDurasiWaktu($ruangan);
                $waktu_selesai_dilayani = now()->addSeconds($durasi_waktu);

                // Simpan waktu selesai dilayani dalam sesi
                session(['waktu_selesai_dilayani' => $waktu_selesai_dilayani]);
            }
        }
    }
}
