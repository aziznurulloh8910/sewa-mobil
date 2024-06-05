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

    function update_profile(Request $request, $id) {
        try {
            $validated = $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email:dns|unique:users,email,' . $id,
                'current_password' => 'required',
                'new_password' => 'required|min:5|max:255'
            ]);

            $user = auth()->user();
            if (!Hash::check($validated['current_password'], $user->password)) {
                return redirect()->route('profile', $id)
                    ->withErrors(['current_password' => 'The current password is incorrect'])
                    ->withInput();
            }

            $user->name = $validated['name'];
            $user->email = $validated['email'];
            if ($validated['new_password']) {
                $user->password = Hash::make($validated['new_password']);
            }
            $user->role = 0;
            $user->save();

            return redirect('/profile')->with('success', 'User has been updated');
        } catch (ValidationException $e) {
            return redirect()->route('profile', $id)
                ->withErrors($e->errors())
                ->withInput();
        }
    }

    public function delete_account_at_profile($id) {
        $user = Auth::user();

        if ($user->id != $id) {
            return redirect()->route('profile')->with('error', 'Unauthorized action.');
        }

        $user->delete();

        return redirect('/register')->with('success', 'Your account has been deleted.');
    }

    function forgot_password_view() {
        return view('auth.forgot-password');
    }

    function reset_password_view() {
        return view('auth.reset-password');
    }

    function forgot_password_post(Request $request) {
        return redirect('reset-password');
    }

}
