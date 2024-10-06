<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarReturn;
use App\Models\Rental;
use Carbon\Carbon;

class CarReturnController extends Controller
{
    public function index()
    {
        $cars = Rental::where('status', 'active')
                      ->with('car')
                      ->get()
                      ->pluck('car');

        return view('car_return.index', compact('cars'));
    }

    public function store(Request $request)
    {
        $rental = Rental::where('car_id', $request->car_id)
                        ->where('status', 'active')
                        ->first();

        if (!$rental) {
            return response()->json(['error' => 'Mobil tidak ditemukan atau tidak disewa oleh Anda.'], 404);
        }

        $returnDate = Carbon::now();
        $totalDays = $returnDate->diffInDays(Carbon::parse($rental->start_date));
        $totalCost = $totalDays * $rental->car->rental_rate;

        CarReturn::create([
            'rental_id' => $rental->id,
            'return_date' => $returnDate,
            'total_days' => $totalDays,
            'total_cost' => $totalCost,
        ]);

        $rental->update(['status' => 'returned']);

        $rental->car->update(['availability' => true]);

        return response()->json(['success' => 'Mobil berhasil dikembalikan.']);
    }
}
