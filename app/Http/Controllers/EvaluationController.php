<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Criteria;
use App\Models\Evaluation;
use App\Models\DeletionHistory;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvaluationController extends Controller
{
    public function index() {
        $criteria = Criteria::with('subCriteria')->get();
        return view('evaluation.index', compact('criteria'));
    }

    public function dataTable() {
        $criteria = Criteria::all();
        $data = Asset::latest()->get()->map(function ($item) use ($criteria) {
            $item->is_evaluated = Evaluation::where('asset_id', $item->id)->exists();
            foreach ($criteria as $criterion) {
                $evaluation = Evaluation::where('asset_id', $item->id)
                                        ->where('criteria_id', $criterion->id)
                                        ->with('subCriteria')
                                        ->first();
                $item['criteria_' . $criterion->id] = $evaluation ? $evaluation->subCriteria->score : null;
            }
            return $item;
        });

        $this->ensureAllCriteriaColumns($data, $criteria);

        \Log::info($data); // Log data untuk debugging

        return response()->json(['data' => $data]);
    }

    private function ensureAllCriteriaColumns($data, $criteria) {
        $data->each(function ($item) use ($criteria) {
            foreach ($criteria as $criterion) {
                if (!isset($item['criteria_' . $criterion->id])) {
                    $item['criteria_' . $criterion->id] = null;
                }
            }
        });
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'asset_id' => 'required',
            'criteria' => 'required|array',
            'criteria.*' => 'required|exists:sub_criterias,id',
        ]);

        foreach ($validated['criteria'] as $criteriaId => $subCriteriaId) {
            Evaluation::updateOrCreate(
                ['asset_id' => $validated['asset_id'], 'criteria_id' => $criteriaId],
                ['sub_criteria_id' => $subCriteriaId]
            );
        }

        return response()->json(['success' => 'Data penilaian berhasil disimpan.']);
    }

    public function edit($id) {
        $asset = Asset::findOrFail($id);
        $criteria = Criteria::with('subCriteria')->get();
        $evaluations = Evaluation::where('asset_id', $id)->get()->keyBy('criteria_id');

        return response()->json([
            'asset' => $asset,
            'criteria' => $criteria,
            'evaluations' => $evaluations
        ]);
    }

    public function ranking() {
        $criteria = Criteria::all();
        $assets = Asset::all();
        $evaluations = Evaluation::with('subCriteria')->get();

        $decisionMatrix = $this->createDecisionMatrix($assets, $criteria, $evaluations);
        $normalizedMatrix = $this->normalizeMatrix($decisionMatrix);
        $weightedMatrix = $this->weightMatrix($normalizedMatrix, $criteria);
        $idealSolutions = $this->calculateIdealSolutions($weightedMatrix, $criteria);
        $distances = $this->calculateDistances($weightedMatrix, $idealSolutions);
        $preferences = $this->calculatePreferences($distances);

        $rankedAssets = $this->rankAssets($assets, $preferences);

        return view('ranking.index', ['rankedAssets' => $rankedAssets]);
    }

    public function rankingDataTable() {
        $criteria = Criteria::all();
        $assets = Asset::all();
        $evaluations = Evaluation::with('subCriteria')->get();

        $decisionMatrix = $this->createDecisionMatrix($assets, $criteria, $evaluations);
        $normalizedMatrix = $this->normalizeMatrix($decisionMatrix);
        $weightedMatrix = $this->weightMatrix($normalizedMatrix, $criteria);
        $idealSolutions = $this->calculateIdealSolutions($weightedMatrix, $criteria);
        $distances = $this->calculateDistances($weightedMatrix, $idealSolutions);
        $preferences = $this->calculatePreferences($distances);

        $rankedAssets = $this->rankAssets($assets, $preferences);

        $data = $rankedAssets->sortByDesc('preference')->values()->map(function ($item, $index) {
            return [
                'rank' => $index + 1,
                'asset_code' => $item['asset']->asset_code,
                'asset_name' => $item['asset']->name,
                'preference_value' => $item['preference'],
                'id' => $item['asset']->id
            ];
        });

        return response()->json(['data' => $data]);
    }

    public function process() {
        $criteria = Criteria::all();
        $assets = Asset::all();
        $evaluations = Evaluation::with('subCriteria')->get();

        $decisionMatrix = $this->createDecisionMatrix($assets, $criteria, $evaluations);
        $normalizedMatrix = $this->normalizeMatrix($decisionMatrix);
        $weightedMatrix = $this->weightMatrix($normalizedMatrix, $criteria);
        $idealSolutions = $this->calculateIdealSolutions($weightedMatrix, $criteria);
        $distances = $this->calculateDistances($weightedMatrix, $idealSolutions);
        $preferences = $this->calculatePreferences($distances);

        $rankedAssets = $this->rankAssets($assets, $preferences);

        return view('evaluation.process', [
            'criteria' => $criteria,
            'assets' => $assets,
            'decisionMatrix' => $decisionMatrix,
            'normalizedMatrix' => $normalizedMatrix,
            'weightedMatrix' => $weightedMatrix,
            'idealPositive' => $idealSolutions['positive'],
            'idealNegative' => $idealSolutions['negative'],
            'distances' => $distances,
            'preferences' => $preferences,
            'rankedAssets' => $rankedAssets
        ]);
    }

    private function createDecisionMatrix($assets, $criteria, $evaluations) {
        $decisionMatrix = [];
        foreach ($assets as $asset) {
            $row = [];
            foreach ($criteria as $criterion) {
                $evaluation = $evaluations->filter(function ($eval) use ($asset, $criterion) {
                    return $eval->asset_id == $asset->id && $eval->criteria_id == $criterion->id;
                })->first();
                // Hanya tambahkan nilai jika tidak 0
                if ($evaluation && $evaluation->subCriteria->score > 0) {
                    $row[] = $evaluation->subCriteria->score;
                }
            }
            // Tambahkan baris hanya jika ada nilai yang valid
            if (!empty($row)) {
                $decisionMatrix[] = $row;
            }
        }
        return $decisionMatrix;
    }

    private function normalizeMatrix($decisionMatrix) {
        $normalizedMatrix = [];
        foreach ($decisionMatrix as $row) {
            $normalizedRow = [];
            foreach ($row as $index => $value) {
                $columnValues = array_column($decisionMatrix, $index);
                $columnSum = sqrt(array_sum(array_map(function($val) {
                    return pow($val, 2);
                }, $columnValues)));
                $normalizedRow[] = $columnSum != 0 ? number_format($value / $columnSum, 3) : number_format(0, 3);
            }
            $normalizedMatrix[] = $normalizedRow;
        }
        return $normalizedMatrix;
    }

    private function calculateCriteriaWeights($criteria) {
        $total = array_sum(range(1, count($criteria)));
        $weights = [];
        foreach ($criteria as $index => $criterion) {
            $weights[] = (count($criteria) - $index) / $total;
        }
        return $weights;
    }

    private function weightMatrix($normalizedMatrix, $criteria) {
        $weights = $this->calculateCriteriaWeights($criteria);
        $weightedMatrix = [];
        foreach ($normalizedMatrix as $row) {
            $weightedRow = [];
            foreach ($row as $index => $value) {
                $weightedRow[] = number_format($value * $weights[$index], 3);
            }
            $weightedMatrix[] = $weightedRow;
        }
        return $weightedMatrix;
    }

    private function calculateIdealSolutions($weightedMatrix, $criteria) {
        $idealPositive = [];
        $idealNegative = [];

        foreach ($criteria as $index => $criterion) {
            $columnValues = array_column($weightedMatrix, $index);
            if ($criterion->attribute == 'benefit') {
                $idealPositive[] = max($columnValues);
                $idealNegative[] = min($columnValues);
            } else if ($criterion->attribute == 'cost') {
                $idealPositive[] = min($columnValues);
                $idealNegative[] = max($columnValues);
            }
        }

        return [
            'positive' => $idealPositive,
            'negative' => $idealNegative
        ];
    }

    private function calculateDistances($weightedMatrix, $idealSolutions) {
        $distances = [];
        foreach ($weightedMatrix as $row) {
            $positiveDistance = sqrt(array_sum(array_map(function ($value, $ideal) {
                return pow($value - $ideal, 2);
            }, $row, $idealSolutions['positive'])));
            $negativeDistance = sqrt(array_sum(array_map(function ($value, $ideal) {
                return pow($value - $ideal, 2);
            }, $row, $idealSolutions['negative'])));
            $distances[] = [
                'positive' => number_format($positiveDistance, 3),
                'negative' => number_format($negativeDistance, 3)
            ];
        }
        return $distances;
    }

    private function calculatePreferences($distances) {
        return array_map(function ($distance) {
            $denominator = $distance['positive'] + $distance['negative'];
            return $denominator != 0 ? number_format($distance['negative'] / $denominator, 3) : number_format(0, 3);
        }, $distances);
    }

    private function rankAssets($assets, $preferences) {
        // Tambahkan aset dengan preferensi 0 untuk yang tidak ada dalam preferensi
        $rankedAssets = $assets->map(function ($asset, $index) use ($preferences) {
            return ['asset' => $asset, 'preference' => isset($preferences[$index]) ? number_format($preferences[$index], 3) : number_format(0, 3)];
        });

        // Urutkan berdasarkan preferensi
        return $rankedAssets->sortByDesc('preference');
    }

    public function deleteAsset($id) {
        DB::transaction(function () use ($id) {
            $asset = Asset::findOrFail($id);
            DeletionHistory::create([
                'user_id' => auth()->user()->id,
                'asset_id' => $asset->id,
                'residual_value' => $asset->accumulated_depreciation,
                'description' => $asset->condition,
                'date_of_deletion' => now(),
            ]);
            $asset->delete();
        });

        return response()->json(['success' => 'Asset deleted successfully.']);
    }

    public function maintainAsset($id) {
        DB::transaction(function () use ($id) {
            $asset = Asset::findOrFail($id);
            $defaultCost = $asset->acquisition_cost - $asset->accumulated_depreciation;
            Maintenance::create([
                'asset_id' => $asset->id,
                'description' => $asset->description,
                'cost' => $defaultCost,
                'status' => 'planned',
                'maintenance_date' => now(),
            ]);
            $asset->description = 'maintain';
            $asset->save();
        });

        return response()->json(['success' => 'Asset marked for maintenance.']);
    }
}
