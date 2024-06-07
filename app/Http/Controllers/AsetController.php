<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use Illuminate\Support\Facades\Auth;

class AsetController extends Controller
{
    function index() {
        return view('asset.index');
    }

    function dataTable() {
        $data = Asset::latest()->get();
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
        $validated['user_id'] = Auth::id();

        Asset::create($validated);

        return response()->json(['success' => 'Asset added successfully.']);
    }

    public function show($id)
    {
        $asset = Asset::findOrFail($id);
        return response()->json($asset);
    }

    public function update(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);

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

        $asset->update($validated);

        return response()->json(['success' => 'Asset updated successfully.']);
    }

    public function delete($id) {
        $asset = Asset::findOrFail($id);
        $asset->delete();

        return response()->json(['success' => 'Asset deleted successfully.']);
    }
}
