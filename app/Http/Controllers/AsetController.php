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
        // Logging untuk memastikan method dijalankan
        Log::info('Store method accessed.');

        // Logging data yang diterima
        Log::info('Request Data: ', $request->all());

        // Debugging dengan dd()
        // dd($request->all());

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'registration_number' => 'required|integer',
            'asset_code' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'brand_type' => 'required|string|max:255',
            'procurement_year' => 'required|integer',
            'quantity' => 'required|integer',
            'acquisition_cost' => 'required|numeric',
            'condition' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        // Logging setelah validasi
        Log::info('Validated Data: ', $validated);

        // Perhitungan nilai yang terekam dan akumulasi depresiasi
        $validated['recorded_value'] = $request->acquisition_cost * $request->quantity;
        $validated['accumulated_depreciation'] = $request->procurement_year;
        $validated['total_depreciation'] = $validated['accumulated_depreciation'];

        try {
            // Menyimpan data manual untuk pengujian
            $aset = new Aset();
            $aset->name = $validated['name'];
            $aset->registration_number = $validated['registration_number'];
            $aset->asset_code = $validated['asset_code'];
            $aset->location = $validated['location'];
            $aset->brand_type = $validated['brand_type'];
            $aset->procurement_year = $validated['procurement_year'];
            $aset->quantity = $validated['quantity'];
            $aset->acquisition_cost = $validated['acquisition_cost'];
            $aset->condition = $validated['condition'];
            $aset->description = $validated['description'] ?? '';
            $aset->recorded_value = $validated['recorded_value'];
            $aset->accumulated_depreciation = $validated['accumulated_depreciation'];
            $aset->total_depreciation = $validated['total_depreciation'];
            $aset->save();

            // Logging setelah data disimpan
            Log::info('Data Saved: ', $aset->toArray());

            return redirect('/aset')->with('success', 'New Data has been added');
        } catch (\Exception $e) {
            // Logging error jika terjadi masalah saat menyimpan data
            Log::error('Error Saving Data: ' . $e->getMessage());

            return redirect('/aset')->with('error', 'Failed to add new data');
        }
    }
}
