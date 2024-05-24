<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoryPenghapusanController extends Controller
{
    function index() {
        return view('history.index');
    }
}
