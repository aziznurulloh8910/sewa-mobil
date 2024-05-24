<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    function index() {
        return view('kriteria.index');
    }
}
