<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Criteria;
use App\Models\Evaluation;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function index() {
        $criteria = Criteria::with('subCriteria')->get();
        return view('evaluation.index', compact('criteria'));
    }

    function dataTable() {
        $criteria = Criteria::all();
        $data = Asset::latest()->get()->map(function ($item) use ($criteria) {
            $item->is_evaluated = Evaluation::where('asset_id', $item->id)->exists();
            foreach ($criteria as $criterion) {
                $evaluation = Evaluation::where('asset_id', $item->id)
                                        ->where('criteria_id', $criterion->id)
                                        ->with('subCriteria') // Pastikan relasi subCriteria di-load
                                        ->first();
                $item['criteria_' . $criterion->id] = $evaluation ? $evaluation->subCriteria->score : null; // Mengembalikan skor subkriteria
            }
            return $item;
        });

        // Pastikan setiap item memiliki semua kolom criteria_*
        $data->each(function ($item) use ($criteria) {
            foreach ($criteria as $criterion) {
                if (!isset($item['criteria_' . $criterion->id])) {
                    $item['criteria_' . $criterion->id] = null;
                }
            }
        });

        // Log data untuk debugging
        \Log::info($data);

        return response()->json(['data' => $data]);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'asset_id' => 'required',
            'criteria' => 'required|array',
            'criteria.*' => 'required|exists:sub_criterias,id',
        ]);

        // Proses penyimpanan data
        foreach ($validated['criteria'] as $criteriaId => $subCriteriaId) {
            // Simpan data ke database
            Evaluation::updateOrCreate(
                ['asset_id' => $validated['asset_id'], 'criteria_id' => $criteriaId],
                ['sub_criteria_id' => $subCriteriaId]
            );
        }

        return response()->json(['success' => 'Data penilaian berhasil disimpan.']);
    }

    public function ranking() {
        $criteria = Criteria::all();
        $assets = Asset::all();

        // Ambil data evaluasi
        $evaluations = Evaluation::with('subCriteria')->get();

        // Matriks keputusan
        $decisionMatrix = [];
        foreach ($assets as $asset) {
            $row = [];
            foreach ($criteria as $criterion) {
                $evaluation = $evaluations->filter(function ($eval) use ($asset, $criterion) {
                    return $eval->asset_id == $asset->id && $eval->criteria_id == $criterion->id;
                })->first();
                $row[] = $evaluation ? $evaluation->subCriteria->score : 0;
            }
            $decisionMatrix[] = $row;
        }

        // Normalisasi matriks keputusan
        $normalizedMatrix = [];
        foreach ($decisionMatrix as $row) {
            $normalizedRow = [];
            foreach ($row as $index => $value) {
                $columnSum = sqrt(array_sum(array_column($decisionMatrix, $index)));
                $normalizedRow[] = $columnSum != 0 ? $value / $columnSum : 0;
            }
            $normalizedMatrix[] = $normalizedRow;
        }

        // Bobot kriteria (misalnya bobot sama untuk semua kriteria)
        $weights = array_fill(0, count($criteria), 1 / count($criteria));

        // Matriks ternormalisasi terbobot
        $weightedMatrix = [];
        foreach ($normalizedMatrix as $row) {
            $weightedRow = [];
            foreach ($row as $index => $value) {
                $weightedRow[] = $value * $weights[$index];
            }
            $weightedMatrix[] = $weightedRow;
        }

        // Solusi ideal positif dan negatif
        $idealPositive = array_map('max', array_map(null, ...$weightedMatrix));
        $idealNegative = array_map('min', array_map(null, ...$weightedMatrix));

        // Jarak ke solusi ideal
        $distances = [];
        foreach ($weightedMatrix as $row) {
            $positiveDistance = sqrt(array_sum(array_map(function ($value, $ideal) {
                return pow($value - $ideal, 2);
            }, $row, $idealPositive)));
            $negativeDistance = sqrt(array_sum(array_map(function ($value, $ideal) {
                return pow($value - $ideal, 2);
            }, $row, $idealNegative)));
            $distances[] = ['positive' => $positiveDistance, 'negative' => $negativeDistance];
        }

        // Nilai preferensi
        $preferences = array_map(function ($distance) {
            return $distance['negative'] / ($distance['positive'] + $distance['negative']);
        }, $distances);

        // Urutkan aset berdasarkan nilai preferensi
        $rankedAssets = $assets->map(function ($asset, $index) use ($preferences) {
            return ['asset' => $asset, 'preference' => $preferences[$index]];
        })->sortByDesc('preference');

        return view('ranking.index', ['rankedAssets' => $rankedAssets]);
    }

    public function process() {
        $criteria = Criteria::all();
        $assets = Asset::all();

        // Ambil data evaluasi
        $evaluations = Evaluation::with('subCriteria')->get();

        // Matriks keputusan
        $decisionMatrix = [];
        foreach ($assets as $asset) {
            $row = [];
            foreach ($criteria as $criterion) {
                $evaluation = $evaluations->filter(function ($eval) use ($asset, $criterion) {
                    return $eval->asset_id == $asset->id && $eval->criteria_id == $criterion->id;
                })->first();
                $row[] = $evaluation ? $evaluation->subCriteria->score : 0;
            }
            $decisionMatrix[] = $row;
        }

        // Normalisasi matriks keputusan
        $normalizedMatrix = [];
        foreach ($decisionMatrix as $row) {
            $normalizedRow = [];
            foreach ($row as $index => $value) {
                $columnSum = sqrt(array_sum(array_column($decisionMatrix, $index)));
                $normalizedRow[] = $columnSum != 0 ? $value / $columnSum : 0;
            }
            $normalizedMatrix[] = $normalizedRow;
        }

        // Bobot kriteria (misalnya bobot sama untuk semua kriteria)
        $weights = array_fill(0, count($criteria), 1 / count($criteria));

        // Matriks ternormalisasi terbobot
        $weightedMatrix = [];
        foreach ($normalizedMatrix as $row) {
            $weightedRow = [];
            foreach ($row as $index => $value) {
                $weightedRow[] = $value * $weights[$index];
            }
            $weightedMatrix[] = $weightedRow;
        }

        // Solusi ideal positif dan negatif
        $idealPositive = array_map('max', array_map(null, ...$weightedMatrix));
        $idealNegative = array_map('min', array_map(null, ...$weightedMatrix));

        // Jarak ke solusi ideal
        $distances = [];
        foreach ($weightedMatrix as $row) {
            $positiveDistance = sqrt(array_sum(array_map(function ($value, $ideal) {
                return pow($value - $ideal, 2);
            }, $row, $idealPositive)));
            $negativeDistance = sqrt(array_sum(array_map(function ($value, $ideal) {
                return pow($value - $ideal, 2);
            }, $row, $idealNegative)));
            $distances[] = ['positive' => $positiveDistance, 'negative' => $negativeDistance];
        }

        // Nilai preferensi
        $preferences = array_map(function ($distance) {
            return $distance['negative'] / ($distance['positive'] + $distance['negative']);
        }, $distances);

        // Urutkan aset berdasarkan nilai preferensi
        $rankedAssets = $assets->map(function ($asset, $index) use ($preferences) {
            return ['asset' => $asset, 'preference' => $preferences[$index]];
        })->sortByDesc('preference');

        return view('evaluation.process', [
            'criteria' => $criteria,
            'assets' => $assets,
            'decisionMatrix' => $decisionMatrix,
            'normalizedMatrix' => $normalizedMatrix,
            'weightedMatrix' => $weightedMatrix,
            'idealPositive' => $idealPositive,
            'idealNegative' => $idealNegative,
            'distances' => $distances,
            'preferences' => $preferences,
            'rankedAssets' => $rankedAssets
        ]);
    }
}