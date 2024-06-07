<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aset;
use Illuminate\Support\Facades\Log;

class AsetController extends Controller
{
    function index() {
        return view('aset.index');
    }

    function dataTable() {
        $data = Aset::latest()->get();
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'asset_code' => 'required|string|max:255',
            'registration_number' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'brand_type' => 'required|string|max:255',
            'procurement_year' => 'required|integer',
            'quantity' => 'required|integer',
            'acquisition_cost' => 'required|numeric',
            'condition' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        $validated['recorded_value'] = $request->acquisition_cost * $request->quantity;
        $validated['accumulated_depreciation'] = $request->procurement_year;
        $validated['total_depreciation'] = $validated['accumulated_depreciation'];

        Aset::create($validated);

        return response()->json(['success' => 'Asset added successfully.']);
    }

    public function show($id)
    {
        $aset = Aset::findOrFail($id);
        return response()->json($aset);
    }

    public function update(Request $request, $id)
    {
        $aset = Aset::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'asset_code' => 'required|string|max:255',
            'registration_number' => 'required|integer',
            'location' => 'required|string|max:255',
            'brand_type' => 'required|string|max:255',
            'procurement_year' => 'required|integer',
            'quantity' => 'required|integer',
            'acquisition_cost' => 'required|integer',
            'condition' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        $validated['recorded_value'] = $request->acquisition_cost * $request->quantity;
        $validated['accumulated_depreciation'] = $request->procurement_year;
        $validated['total_depreciation'] = $validated['accumulated_depreciation'];

        $aset->update($validated);

        return response()->json(['success' => 'Data aset berhasil diperbarui']);
    }

    public function delete($id) {
        $aset = Aset::findOrFail($id);
        $aset->delete();

        return response()->json(['success' => 'Data aset berhasil dihapus']);
    }
}
