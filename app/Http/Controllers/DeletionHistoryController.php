<?php

namespace App\Http\Controllers;

use App\Models\DeletionHistory;
use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeletionHistoryController extends Controller
{
    public function index()
    {
        $data = Asset::all();
        return view('history.index', compact('data'));
    }

    function dataTable() {
        $data = DeletionHistory::with(['user', 'asset'])->latest()->get();
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'asset_id' => 'required',
            'date_of_deletion' => 'required|date',
            'residual_value' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();

        DeletionHistory::create($data);

        return response()->json(['success' => 'Asset Deletion History successfully added.']);
    }

    public function show($id)
    {
        $history = DeletionHistory::findOrFail($id);
        return response()->json($history);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'asset_id' => 'required',
            'date_of_deletion' => 'required|date',
            'residual_value' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $history = DeletionHistory::findOrFail($id);
        $data = $request->all();
        $data['user_id'] = Auth::id();

        $history->update($data);

        return response()->json(['success' => 'Asset Deletion History successfully updated.']);
    }

    public function destroy($id)
    {
        $history = DeletionHistory::findOrFail($id);
        $history->delete();

        return response()->json(['success' => 'Asset Deletion History successfully deleted.']);
    }
}