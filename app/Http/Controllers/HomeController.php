<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Car;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil data yang dibutuhkan dari model
        $totalCar = Car::count();
        $carAvailable = Car::where('availability', 'available')->count();
        $carRented = Car::where('availability', 'not available')->count();

        // Pass data ke view
        return view('home', compact('totalCar', 'carAvailable', 'carRented'));
    }
}
