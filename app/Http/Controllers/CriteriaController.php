<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Criteria;

class CriteriaController extends Controller
{
    public function index () {
        return view('criteria.index');
    }

    public function dataTable () {
        $data = Criteria::latest()->get();
        return response()->json(['data' => $data]);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'criteria_code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'attribute' => 'required',
            'weight' => 'required|integer',
        ]);

        Criteria::create($validated);

        return response()->json(['success' => 'Criteria added successfuly.']);
    }

    public function show($id)
    {
        $criteria = Criteria::findOrFail($id);
        return response()->json($criteria);
    }

    public function update(Request $request, $id)
    {
        $criteria = Criteria::findOrFail($id);

        $validated = $request->validate([
            'criteria_code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'attribute' => 'required',
            'weight' => 'required|integer',
        ]);

        $criteria->update($validated);

        return response()->json(['success' => 'Criteria updated successfuly.']);
    }

    public function delete($id) {
        $criteria = Criteria::findOrFail($id);
        $criteria->delete();

        return response()->json(['success' => 'Criteria deleted successfully.']);
    }
}
