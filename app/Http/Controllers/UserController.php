<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    function index() {
        $data = User::latest()->get();
        return view('users.index', [
            'data' => $data
        ]);
    }
}
