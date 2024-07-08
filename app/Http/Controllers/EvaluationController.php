<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Criteria;
use App\Models\Evaluation;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function index() {
        return view('evaluation.index');
    }

    function dataTable() {
        $data = Asset::latest()->get();
        return response()->json(['data' => $data]);
    }

    public function store(Request $request) {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'criteria_id' => 'required|exists:criterias,id',
            'sub_criteria_id' => 'required|exists:sub_criterias,id',
        ]);

        $evaluation = new Evaluation();
        $evaluation->asset_id = $request->asset_id;
        $evaluation->criteria_id = $request->criteria_id;
        $evaluation->sub_criteria_id = $request->sub_criteria_id;
        $evaluation->save();

        return response()->json(['success' => 'Penilaian berhasil disimpan']);
    }
}