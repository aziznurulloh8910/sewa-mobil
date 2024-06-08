<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubCriteriaController extends Controller
{
    public function index() {
        return view('subCriteria.index');
    }
}
