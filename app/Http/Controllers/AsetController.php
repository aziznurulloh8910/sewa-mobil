<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aset;

class AsetController extends Controller
{
    function index() {
        $data = Aset::latest()->get();

        return view('aset.index');
    }

    function dataTable() {
        $data = Aset::latest()->get();
        return response()->json(['data' => $data]);
    }
}
