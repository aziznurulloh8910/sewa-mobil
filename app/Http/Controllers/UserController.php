<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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

    function detail(User $user) {
        return view('users.index', ['user' => $user]);
    }

    function update(Request $request, $id) {
        try {
            $validated = $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email:dns|unique:users,email,' . $id,
                'password' => 'required|min:5|max:255'
            ]);

            $validated['role'] = 0;
            $validated['password'] = Hash::make($validated['password']);

            User::where('id', $id)->update($validated);

            return redirect('/users')->with('success', 'User has been updated');
        } catch (ValidationException $e) {
            dd($e->errors());
        }
    }

    function delete($id) {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/users')->with('success', 'User has been deleted');
    }
}
