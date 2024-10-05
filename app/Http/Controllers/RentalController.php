<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rental;
use App\Models\User; 
use App\Models\Car; 

class RentalController extends Controller
{
    function index() {
        $users = User::all();
        $cars = Car::all();   
        return view('rental.index', compact('users', 'cars')); 
    }

    function dataTable() {
        $data = Rental::with(['user', 'car'])->latest()->get();
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'total_days' => 'required|integer|min:1',
            'total_cost' => 'required|numeric',
            'status' => 'required|string|max:20',
        ]);

        Rental::create($validated);

        return response()->json(['success' => 'Rental added successfully.']);
    }

    public function show($id)
    {
        $data = Rental::with(['user', 'car'])->findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $rental = Rental::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'total_days' => 'required|integer|min:1',
            'total_cost' => 'required|numeric',
            'status' => 'required|string|max:20',
        ]);

        $rental->update($validated);

        return response()->json(['success' => 'Rental updated successfully.']);
    }

    public function delete($id) {
        $data = Rental::findOrFail($id);
        
        $data->delete();

        return response()->json(['success' => 'Rental deleted successfully.']);
    }
}
