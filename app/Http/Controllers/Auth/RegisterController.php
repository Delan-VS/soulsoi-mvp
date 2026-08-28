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
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'regex:/^[0-9]{10}$/', 'unique:users,phone'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:farmer,investor'],
        ];

        if ($request->role === 'farmer') {
            $rules['address'] = ['nullable', 'string', 'max:255'];
            $rules['district'] = ['nullable', 'string', 'max:100'];
            $rules['state'] = ['nullable', 'string', 'max:100'];
            $rules['aadhar_number'] = ['nullable', 'string', 'regex:/^[0-9]{12}$/'];
            $rules['bank_name'] = ['nullable', 'string', 'max:100'];
            $rules['account_number'] = ['nullable', 'string', 'regex:/^[0-9]{9,18}$/'];
            $rules['ifsc_code'] = ['nullable', 'string', 'regex:/^[A-Za-z]{4}0[A-Za-z0-9]{6}$/'];
            $rules['aadhar_front'] = ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:10240'];
            $rules['aadhar_back'] = ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:10240'];
            $rules['pan_card'] = ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:10240'];
            $rules['land_certificate'] = ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:10240'];
        }

        $messages = [
            'phone.regex' => 'Phone number must be a valid 10-digit mobile number.',
            'phone.unique' => 'This phone number is already registered.',
            'aadhar_number.regex' => 'Aadhaar number must be a valid 12-digit numeric number.',
            'account_number.regex' => 'Account number must be between 9 and 18 digits.',
            'ifsc_code.regex' => 'IFSC code must be an 11-character code (e.g. SBIN0001234).',
        ];

        $request->validate($rules, $messages);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'is_admin' => false,
            'investor_status' => $request->role === 'investor' ? 'pending' : 'n/a',
        ]);

        if ($request->role === 'farmer') {
            $aadharFrontPath = $request->hasFile('aadhar_front') ? $request->file('aadhar_front')->store('farmers/documents', 'public') : null;
            $aadharBackPath = $request->hasFile('aadhar_back') ? $request->file('aadhar_back')->store('farmers/documents', 'public') : null;
            $panCardPath = $request->hasFile('pan_card') ? $request->file('pan_card')->store('farmers/documents', 'public') : null;
            $landCertPath = $request->hasFile('land_certificate') ? $request->file('land_certificate')->store('farmers/documents', 'public') : null;

            Farmer::create([
                'user_id' => $user->id,
                'full_name' => $request->name,
                'address' => $request->address ?? 'N/A',
                'village' => 'N/A',
                'district' => $request->district ?? 'Kerala',
                'state' => $request->state ?? 'Kerala',
                'aadhar_number' => $request->aadhar_number ?? 'N/A',
                'bank_name' => $request->bank_name ?? 'N/A',
                'account_holder_name' => $request->name,
                'account_number' => $request->account_number ?? 'N/A',
                'ifsc_code' => $request->ifsc_code ?? 'N/A',
                'dob' => '1990-01-01',
                'overall_status' => 'pending',
                'aadhar_front_path' => $aadharFrontPath,
                'aadhar_back_path' => $aadharBackPath,
                'pan_card_path' => $panCardPath,
                'land_certificate_path' => $landCertPath,
            ]);

            if (auth()->check() && auth()->user()->is_admin) {
                return redirect()->route('admin.farmers.index')->with('success', 'Farmer application registered successfully and added to pending approval queue.');
            }

            return redirect()->route('login')->with('success', 'Your farmer application has been submitted successfully! An Admin will review and approve your account.');
        }

        if ($request->role === 'investor') {
            if (auth()->check() && auth()->user()->is_admin) {
                return redirect()->route('admin.dashboard', ['tab' => 'investors'])->with('success', 'Investor application registered successfully and added to pending approval queue.');
            }

            return redirect()->route('login')->with('success', 'Your investor account registration has been submitted! An Admin must review and approve your account before you can sign in.');
        }

        return redirect('/');
    }
}
