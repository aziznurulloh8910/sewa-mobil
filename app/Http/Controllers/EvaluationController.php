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
        $data = Asset::latest()->get();
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
            Evaluation::create([
                'asset_id' => $validated['asset_id'],
                'criteria_id' => $criteriaId,
                'sub_criteria_id' => $subCriteriaId,
            ]);
        }

        return response()->json(['success' => 'Data penilaian berhasil disimpan.']);
    }
}