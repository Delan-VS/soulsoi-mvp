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
        if ($request->filled('phone')) {
            $rawPhone = trim($request->phone);
            if (!str_starts_with($rawPhone, '+91')) {
                $digits = preg_replace('/[^0-9]/', '', $rawPhone);
                if (str_starts_with($digits, '91') && strlen($digits) == 12) {
                    $rawPhone = '+' . $digits;
                } else {
                    $rawPhone = '+91' . preg_replace('/^0+/', '', $digits);
                }
            }
            $cleanPhone = preg_replace('/^\+91\s*/', '+91', $rawPhone);
            $request->merge(['phone' => $cleanPhone]);
        }

        if ($request->filled('ifsc_code')) {
            $request->merge(['ifsc_code' => strtoupper(trim($request->ifsc_code))]);
        }

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => $request->role === 'investor'
                ? ['required', 'string', 'email', 'max:255', 'unique:users,email']
                : ['nullable', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'regex:/^\+91[0-9]{10}$/', 'unique:users,phone'],
            'password' => [
                'required',
                'string',
                'confirmed',
                Rules\Password::min(8)
                    ->letters()
                    ->numbers(),
            ],
            'role' => ['required', 'in:farmer,investor'],
        ];

        if ($request->role === 'farmer') {
            $rules['address'] = ['required', 'string', 'max:255'];
            $rules['district'] = ['required', 'string', 'max:100'];
            $rules['state'] = ['required', 'string', 'max:100'];
            $rules['pincode'] = ['required', 'string', 'regex:/^[0-9]{6}$/'];
            $rules['aadhar_number'] = ['required', 'string', 'regex:/^[0-9]{12}$/'];
            $rules['bank_name'] = ['required', 'string', 'max:100'];
            $rules['ifsc_code'] = ['required', 'string', 'regex:/^[A-Za-z]{4}0[A-Za-z0-9]{6}$/'];
            $rules['account_number'] = ['required', 'string', 'regex:/^[0-9]{9,18}$/', 'confirmed'];
            $rules['account_holder_name'] = ['required', 'string', 'max:255'];
            $rules['aadhar_front'] = ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:1024'];
            $rules['aadhar_back'] = ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:1024'];
            $rules['pan_card'] = ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:1024'];
            $rules['land_certificate'] = ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:1024'];
            $rules['aadhar_front_path'] = ['nullable', 'string'];
            $rules['aadhar_back_path'] = ['nullable', 'string'];
            $rules['pan_card_path'] = ['nullable', 'string'];
            $rules['land_certificate_path'] = ['nullable', 'string'];
        }

        $messages = [
            'email.required' => 'Email address is required for investor registration.',
            'phone.regex' => 'Phone number must start with +91 followed by a 10-digit mobile number.',
            'phone.unique' => 'This phone number is already registered.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
            'aadhar_number.regex' => 'Aadhaar number must be a valid 12-digit numeric number.',
            'pincode.regex' => 'PIN code must be a valid 6-digit postal code.',
            'account_number.regex' => 'Account number must be between 9 and 18 digits.',
            'account_number.confirmed' => 'Account number confirmation does not match.',
            'ifsc_code.regex' => 'IFSC code must be a valid 11-character code (e.g. SBIN0001234, 5th character must be 0).',
            'aadhar_front.max' => 'Aadhaar front file size must not exceed 1MB.',
            'aadhar_back.max' => 'Aadhaar back file size must not exceed 1MB.',
            'pan_card.max' => 'PAN card file size must not exceed 1MB.',
            'land_certificate.max' => 'Additional document file size must not exceed 1MB.',
        ];

        $request->validate($rules, $messages);

        $userEmail = $request->email;
        if (empty($userEmail)) {
            $digits = preg_replace('/[^0-9]/', '', $request->phone);
            $userEmail = 'farmer_' . $digits . '@soulsoil.com';
            if (User::where('email', $userEmail)->exists()) {
                $userEmail = 'farmer_' . $digits . '_' . time() . '@soulsoil.com';
            }
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $userEmail,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'is_admin' => false,
            'investor_status' => 'approved',

        ]);

        if ($request->role === 'farmer') {
            $aadharFrontPath = $request->aadhar_front_path ?? ($request->hasFile('aadhar_front') ? $request->file('aadhar_front')->store('farmers/documents', 'public') : null);
            $aadharBackPath = $request->aadhar_back_path ?? ($request->hasFile('aadhar_back') ? $request->file('aadhar_back')->store('farmers/documents', 'public') : null);
            $panCardPath = $request->pan_card_path ?? ($request->hasFile('pan_card') ? $request->file('pan_card')->store('farmers/documents', 'public') : null);
            $landCertPath = $request->land_certificate_path ?? ($request->hasFile('land_certificate') ? $request->file('land_certificate')->store('farmers/documents', 'public') : null);

            Farmer::create([
                'user_id' => $user->id,
                'full_name' => $request->name,
                'address' => $request->address ?? 'N/A',
                'village' => 'N/A',
                'district' => $request->district ?? 'Kerala',
                'state' => $request->state ?? 'Kerala',
                'pincode' => $request->pincode,
                'aadhar_number' => $request->aadhar_number ?? 'N/A',
                'bank_name' => $request->bank_name ?? 'N/A',
                'account_holder_name' => $request->account_holder_name ?? $request->name,
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

    /**
     * AJAX Document upload handler for registration
     */
    public function uploadDocument(Request $request)
    {
        $request->validate([
            'document' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:1024'],
            'type' => ['required', 'string', 'in:aadhar_front,aadhar_back,pan_card,land_certificate'],
        ], [
            'document.max' => 'Document/Image file size must not exceed 1MB.',
            'document.mimes' => 'Document must be a JPG, JPEG, PNG, or PDF file.',
        ]);

        $path = $request->file('document')->store('farmers/documents', 'public');
        $url = asset('storage/' . $path);
        $filename = $request->file('document')->getClientOriginalName();
        $ext = strtolower($request->file('document')->getClientOriginalExtension());
        $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif']);

        return response()->json([
            'success' => true,
            'path' => $path,
            'url' => $url,
            'filename' => $filename,
            'is_image' => $isImage,
            'type' => $request->type,
        ]);
    }
}
