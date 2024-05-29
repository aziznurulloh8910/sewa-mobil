<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aset;

class AsetController extends Controller
{
    function index() {
        $data = Aset::latest()->get();
        return view('aset.index', [
            'data' => $data,
        ]);
    }
}
