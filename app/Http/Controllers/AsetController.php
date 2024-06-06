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
        // Validasi data
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

        // Perhitungan nilai yang terekam dan akumulasi depresiasi
        $validated['recorded_value'] = $request->acquisition_cost * $request->quantity;
        $validated['accumulated_depreciation'] = $request->procurement_year;
        $validated['total_depreciation'] = $validated['accumulated_depreciation'];

        // Simpan data ke database
        Aset::create($validated);

        return response()->json(['success' => 'Asset added successfully.']);
    }
}
