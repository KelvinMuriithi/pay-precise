<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginAuth(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::where('email', $request->email)->first();
        if (!empty($user)) {
            if ($user->is_active === 1) {
                $credentials = $request->only('email', 'password');
                if (Auth::attempt($credentials)) {
                    $user->update([
                        'is_online' => true,
                    ]);
                    return redirect()->route('dashboard');
                }
                return back()->withErrors(['password' => 'Incorrect Password']);
            }
            return back()->withErrors(['email' => 'Your account is disabled.']);
        }
        return back()->withErrors(['email' => 'Account could not be found.']);
    }


    public function forgotPassword()
    {
        $this->data['pageTitle'] = __('Forgot Password');
        return view('auth.forgot-password', $this->data);
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(notify(__($status)))
            : back()->withErrors(['email' => __($status)]);
    }

    public function resetPassword(string $token)
    {
        $this->data['pageTitle'] = __('Reset Password');
        $this->data['token'] = $token;
        return view('auth.password-reset', $this->data);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
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
            ? redirect()->route('login')->with(notify(__($status)))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function logout(Request $request)
    {
        auth()->user()->update([
            'is_online' => true,
        ]);
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }

}