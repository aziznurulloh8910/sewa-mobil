<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Criteria;
use App\Models\SubCriteria;


class SubCriteriaController extends Controller
{
    public function index()
    {
        $criterias = Criteria::with('subCriteria')->get();
        return view('subcriteria.index', compact('criterias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'criteria_id' => 'required|exists:criterias,id',
            'name' => 'required|string|max:255',
            'score' => 'required|integer',
        ]);

        SubCriteria::create($validated);

        return response()->json(['success' => 'SubCriteria added successfully.']);
    }

    public function show($id)
    {
        $subCriteria = SubCriteria::findOrFail($id);
        return response()->json($subCriteria);
    }

    public function update(Request $request, $id)
    {
        $subCriteria = SubCriteria::findOrFail($id);

        $validated = $request->validate([
            'criteria_id' => 'required|exists:criterias,id',
            'name' => 'required|string|max:255',
            'score' => 'required|integer',
        ]);

        $subCriteria->update($validated);

        return response()->json(['success' => 'SubCriteria updated successfully.']);
    }

    public function delete($id)
    {
        $subCriteria = SubCriteria::findOrFail($id);
        $subCriteria->delete();

        return response()->json(['success' => 'SubCriteria deleted successfully.']);
    }
}
