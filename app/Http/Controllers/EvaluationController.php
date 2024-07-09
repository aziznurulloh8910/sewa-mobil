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
}