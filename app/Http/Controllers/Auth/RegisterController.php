<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Farmer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:15'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:farmer,investor'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'is_admin' => false,
            'investor_status' => $request->role === 'investor' ? 'pending' : 'approved',
        ]);

        if ($request->role === 'farmer') {
            Farmer::create([
                'user_id' => $user->id,
                'full_name' => $request->name,
                'overall_status' => 'pending',
            ]);
        }

        if ($request->role === 'investor') {
            return redirect()->route('login')->withErrors(['email' => 'Your investor account has been created and is pending admin approval.']);
        }

        Auth::login($user);

        if ($request->role === 'farmer') {
            return redirect()->route('farmer.onboarding');
        }

        return redirect('/');
    }
}
