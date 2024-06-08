<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NomorAntrian;
use Phpml\Regression\LeastSquares;
use Phpml\ModelManager;

class MachineLearningController extends Controller
{
    public function showTrainForm()
    {
        return view('simulasi.train-model');
    }

    private function analyzeData(array $data)
    {
        $statistics = [
            'mean' => [],
            'std' => [],
            'min' => [],
            'max' => [],
        ];

        $columns = count($data[0]);
        for ($i = 0; $i < $columns; $i++) {
            $columnData = array_column($data, $i);
            $statistics['mean'][$i] = array_sum($columnData) / count($columnData);
            $statistics['std'][$i] = $this->standardDeviation($columnData);
            $statistics['min'][$i] = min($columnData);
            $statistics['max'][$i] = max($columnData);
        }

        error_log('Statistics: ' . print_r($statistics, true));
    }

    private function standardDeviation(array $a)
    {
        $n = count($a);
        if ($n === 0) {
            return 0;
        }

        $mean = array_sum($a) / $n;
        $sum = 0;
        foreach ($a as $x) {
            $sum += ($x - $mean) ** 2;
        }

        return sqrt($sum / $n);
    }

    public function train()
    {
        $antrian = NomorAntrian::all();

        $samples = [];
        $labels = [];

        foreach ($antrian as $item) {
            $nomor = (float) $item->nomor;
            $createdAt = strtotime($item->created_at);

            if (is_numeric($nomor) && $createdAt !== false) {
                foreach ($item->riwayat_waktu as $riwayat) {
                    $waktu_dilayani = (float) $riwayat['waktu_dilayani'];
                    if (is_numeric($waktu_dilayani)) {
                        $ruangan = $this->ruanganToNumeric($riwayat['ruangan']);
                        $samples[] = [$nomor, $ruangan, $this->dayOfYear($createdAt)];
                        $labels[] = $waktu_dilayani;
                    }
                }
            }
        }

        if (empty($samples) || empty($labels)) {
            return response()->json(['error' => 'Tidak ada data yang valid untuk melatih model'], 400);
        }

        $this->analyzeData($samples);

        $uniqueSamples = array_map('serialize', $samples);
        if (count(array_unique($uniqueSamples)) < count($samples)) {
            return response()->json(['error' => 'Data tidak bervariasi. Tidak bisa melatih model dengan data ini.'], 400);
        }

        $samples = $this->normalizeData($samples);

        try {
            $regression = new LeastSquares();
            $regression->train($samples, $labels);

            $modelManager = new ModelManager();
            $modelManager->saveToFile($regression, storage_path('app/ml-model/regression-model.phpml'));

            return response()->json(['message' => 'Model berhasil dilatih dan disimpan']);
        } catch (\Phpml\Exception\MatrixException $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat melatih model: ' . $e->getMessage()], 500);
        }
    }


    private function ruanganToNumeric($ruangan)
    {
        $ruanganMapping = [
            'poli_umum' => 1,
            'poli_gigi' => 2,
            'poli_kia' => 3,
            'poli_anak' => 4,
            'lab' => 5,
            'apotik' => 6,
        ];

        return $ruanganMapping[$ruangan] ?? 0;
    }

    private function dayOfYear($timestamp)
    {
        return (int)date('z', $timestamp) + 1;
    }

    private function normalizeData(array $data)
    {
        $min = $data[0];
        $max = $data[0];

        foreach ($data as $item) {
            foreach ($item as $index => $value) {
                if ($value < $min[$index]) {
                    $min[$index] = $value;
                }
                if ($value > $max[$index]) {
                    $max[$index] = $value;
                }
            }
        }

        $normalizedData = [];
        foreach ($data as $item) {
            $normalizedItem = [];
            foreach ($item as $index => $value) {
                if ($max[$index] == $min[$index]) {
                    $normalizedItem[] = 0;
                } else {
                    $normalizedItem[] = ($value - $min[$index]) / ($max[$index] - $min[$index]);
                }
            }
            $normalizedData[] = $normalizedItem;
        }

        return $normalizedData;
    }

    public function predict(Request $request)
    {
        $nomor = $request->input('nomor');
        $ruangan = $request->input('ruangan');
        $createdAt = $request->input('created_at');

        if (!is_numeric($nomor) || strtotime($createdAt) === false) {
            return response()->json(['error' => 'Nomor dan created_at harus berupa nilai numerik yang valid'], 400);
        }
        $ruanganNumeric = $this->ruanganToNumeric($ruangan);
        $dayOfYear = $this->dayOfYear(strtotime($createdAt));

        $modelManager = new ModelManager();
        $regression = $modelManager->restoreFromFile(storage_path('app/ml-model/regression-model.phpml'));

        $prediction = $regression->predict([(float)$nomor, $ruanganNumeric, $dayOfYear]);

        return response()->json(['prediction' => $prediction]);
    }
}
