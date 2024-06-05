<?php

namespace App\Http\Controllers;

use DB;
use Mail;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

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

    // modul Forgot Password
    function forgot_password_view() {
        return view('auth.forgot-password');
    }

    function forgot_password_post(Request $request) {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    function reset_password_view($token) {
        return view('auth.reset-password', ['token' => $token]);
    }

    function reset_password_post(Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:5|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }

}
