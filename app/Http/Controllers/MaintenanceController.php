<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Asset;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $data = Asset::all();
        return view('maintenance.index', compact('data'));
    }

    function dataTable() {
        $data = Maintenance::with(['asset'])->latest()->get();
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'asset_id' => 'required',
            'maintenance_date' => 'required|date',
            'cost' => 'required|numeric',
            'status' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $data = $request->all();

        Maintenance::create($data);

        return response()->json(['success' => 'Maintenance record successfully added.']);
    }

    public function show($id)
    {
        $maintenance = Maintenance::findOrFail($id);
        return response()->json($maintenance);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'asset_id' => 'required',
            'maintenance_date' => 'required|date',
            'cost' => 'required|numeric',
            'status' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $maintenance = Maintenance::findOrFail($id);
        $data = $request->all();

        $maintenance->update($data);

        return response()->json(['success' => 'Maintenance record successfully updated.']);
    }

    public function destroy($id)
    {
        $maintenance = Maintenance::findOrFail($id);
        $maintenance->delete();

        return response()->json(['success' => 'Maintenance record successfully deleted.']);
    }
}