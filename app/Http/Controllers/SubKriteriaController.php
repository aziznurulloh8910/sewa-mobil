<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubKriteriaController extends Controller
{
    function index() {
        return view('subKriteria.index');
    }
}
