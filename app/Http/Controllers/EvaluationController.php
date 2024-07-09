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
        $idealSolutions = $this->calculateIdealSolutions($weightedMatrix);
        $distances = $this->calculateDistances($weightedMatrix, $idealSolutions);
        $preferences = $this->calculatePreferences($distances);

        $rankedAssets = $this->rankAssets($assets, $preferences);

        return view('ranking.index', ['rankedAssets' => $rankedAssets]);
    }

    public function process() {
        $criteria = Criteria::all();
        $assets = Asset::all();
        $evaluations = Evaluation::with('subCriteria')->get();

        $decisionMatrix = $this->createDecisionMatrix($assets, $criteria, $evaluations);
        $normalizedMatrix = $this->normalizeMatrix($decisionMatrix);
        $weightedMatrix = $this->weightMatrix($normalizedMatrix, $criteria);
        $idealSolutions = $this->calculateIdealSolutions($weightedMatrix);
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
                $row[] = $evaluation ? $evaluation->subCriteria->score : 0;
            }
            $decisionMatrix[] = $row;
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
                $normalizedRow[] = $columnSum != 0 ? $value / $columnSum : 0; 
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
                $weightedRow[] = $value * $weights[$index];
            }
            $weightedMatrix[] = $weightedRow;
        }
        return $weightedMatrix;
    }

    private function calculateIdealSolutions($weightedMatrix) {
        return [
            'positive' => array_map('max', array_map(null, ...$weightedMatrix)),
            'negative' => array_map('min', array_map(null, ...$weightedMatrix))
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
            $distances[] = ['positive' => $positiveDistance, 'negative' => $negativeDistance];
        }
        return $distances;
    }

    private function calculatePreferences($distances) {
        return array_map(function ($distance) {
            $denominator = $distance['positive'] + $distance['negative'];
            return $denominator != 0 ? $distance['negative'] / $denominator : 0;
        }, $distances);
    }

    private function rankAssets($assets, $preferences) {
        return $assets->map(function ($asset, $index) use ($preferences) {
            return ['asset' => $asset, 'preference' => $preferences[$index]];
        })->sortByDesc('preference');
    }
}