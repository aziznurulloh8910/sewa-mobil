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

    function create(Request $request) {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email'=> 'required|email:dns|unique:users',
            'password' => 'required|min:5|max:255'
        ]);

        $validated['role'] = 0; //default 0 atau role user biasa

        User::create($validated);

        return redirect('/users')->with('success', 'New User has been added');
    }

    function update(Request $request, User $user) {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email'=> 'required|email:dns|unique:users',
            'password' => 'required|min:5|max:255'
        ]);

        $validated['role'] = 0; //default 0 atau role user biasa

        User::where('id', $user->id)->update($validated);

        return redirect('/users')->with('success', 'User has been updated');
    }

    function delete($id) {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/users')->with('success', 'User has been deleted');
    }
}
