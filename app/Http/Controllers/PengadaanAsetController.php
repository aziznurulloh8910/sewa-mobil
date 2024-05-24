<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengadaanAsetController extends Controller
{
    function index() {
        return view('pengadaan.index');
    }
}
