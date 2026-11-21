<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Administrator accounts always have full access
            if ($user->is_admin) {
                $request->session()->regenerate();
                return redirect()->intended(route('admin.dashboard'));
            }

            // 1. Farmer Account Approval Check
            if ($user->farmer) {
                $farmerStatus = strtolower(trim($user->farmer->overall_status ?? 'pending'));

                if ($farmerStatus === 'rejected') {
                    Auth::logout();
                    return back()->withErrors([
                        'email' => 'Your farmer account application has been rejected by the administrator.',
                    ])->onlyInput('email');
                }

                if ($farmerStatus !== 'approved') {
                    Auth::logout();
                    return back()->withErrors([
                        'email' => 'Your farmer account is pending admin verification and approval. You cannot sign in until an administrator approves your account.',
                    ])->onlyInput('email');
                }
            } else {
                // 2. Investor Account Approval Check (for users without a farmer profile)
                $investorStatus = strtolower(trim($user->investor_status ?? 'pending'));

                if ($investorStatus === 'rejected') {
                    Auth::logout();
                    return back()->withErrors([
                        'email' => 'Your investor account application has been rejected by the administrator.',
                    ])->onlyInput('email');
                }

                if ($investorStatus !== 'approved') {
                    Auth::logout();
                    return back()->withErrors([
                        'email' => 'Your investor account is pending admin verification and approval. You cannot sign in until an administrator approves your account.',
                    ])->onlyInput('email');
                }
            }

            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function resetPassword(Request $request)
    {
        $request->validateWithBag('resetPassword', [
            'email' => ['required', 'email'],
            'new_password' => [
                'required',
                'string',
                'confirmed',
                Rules\Password::min(8)
                    ->letters()
                    ->numbers(),
            ],
        ], [
            'new_password.confirmed' => 'New password confirmation does not match.',
            'new_password.min' => 'New password must be at least 8 characters long and include letters and numbers.',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()
                ->withErrors(['email' => 'No account found with this email address.'], 'resetPassword')
                ->withInput($request->only('email'));
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('login')
            ->with('success', 'Password has been reset successfully! You can now sign in with your new password.')
            ->withInput(['email' => $user->email]);
    }

    public function changePassword(Request $request)
    {
        $targetEmail = $request->email ?: (Auth::user()?->email);

        $request->validateWithBag('changePassword', [
            'email' => [Auth::check() ? 'nullable' : 'required', 'email'],
            'current_password' => ['required', 'string'],
            'new_password' => [
                'required',
                'string',
                'confirmed',
                'different:current_password',
                Rules\Password::min(8)
                    ->letters()
                    ->numbers(),
            ],
        ], [
            'new_password.different' => 'The new password must be different from your current password.',
            'new_password.confirmed' => 'New password confirmation does not match.',
            'new_password.min' => 'New password must be at least 8 characters long and include letters and numbers.',
        ]);

        $user = $targetEmail ? User::where('email', $targetEmail)->first() : Auth::user();

        if (!$user || !Hash::check($request->current_password, $user->password)) {
            return back()
                ->withErrors(['current_password' => 'Invalid email address or current password.'], 'changePassword')
                ->withInput($request->only('email'));
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        if (Auth::check()) {
            return back()->with('success', 'Your password has been changed successfully.');
        }

        return redirect()->route('login')
            ->with('success', 'Password changed successfully! You can now sign in with your new password.')
            ->withInput(['email' => $user->email]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
