<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

class CarController extends Controller
{
    function index() {
        return view('car.index');
    }

    function dataTable() {
        $data = Car::latest()->get();
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'license_plate' => 'required|string|max:255',
            'rental_rate' => 'required|numeric',
            'availability' => 'required|boolean',
        ]);

        Car::create($validated);

        return response()->json(['success' => 'Car added successfully.']);
    }

    public function show($id)
    {
        $data = Car::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $car = Car::findOrFail($id);

        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'license_plate' => 'required|string|max:255',
            'rental_rate' => 'required|numeric',
            'availability' => 'required|boolean',
        ]);

        $car->update($validated);

        return response()->json(['success' => 'Car updated successfully.']);
    }

    public function delete($id) {
        $data = Car::findOrFail($id);
        
        $data->delete();

        return response()->json(['success' => 'Car deleted successfully.']);
    }
}
