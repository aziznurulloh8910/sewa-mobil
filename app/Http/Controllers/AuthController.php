<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function registerView(){
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 0;

        $user->save();

        $registeredUser = User::where('email', $request->email)->first();

        return response()->json(['success' => true, 'user' => $registeredUser->name]);
    }


    public function loginView()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credetials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credetials)) {
            $user = Auth::user();
            return response()->json(['success' => true, 'user' => $user->name]);
        }

        return response()->json(['success' => false]);
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}
