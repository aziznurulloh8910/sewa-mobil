<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Criteria;

class CriteriaController extends Controller
{
    public function index () {
        return view('criteria.index');
    }

    public function dataTable () {
        $data = Criteria::latest()->get();
        return response()->json(['data' => $data]);
    }
}
