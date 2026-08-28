<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Farmer;
use Illuminate\Support\Facades\Auth;

class OnboardingController extends Controller
{
    public function index()
    {
        $farmer = Farmer::firstOrCreate(
            ['user_id' => Auth::id()],
            [
                'full_name' => Auth::user()->name,
                'address' => 'N/A',
                'village' => 'N/A',
                'district' => 'Kerala',
                'state' => 'Kerala',
                'aadhar_number' => 'N/A',
                'bank_name' => 'N/A',
                'account_holder_name' => Auth::user()->name,
                'account_number' => 'N/A',
                'ifsc_code' => 'N/A',
                'dob' => '1990-01-01',
                'overall_status' => 'pending',
            ]
        );

        return view('farmer.onboarding', compact('farmer'));
    }

    public function submit(Request $request)
    {
        $rules = [
            'dob' => 'nullable|date',
            'aadhar_number' => ['nullable', 'string', 'regex:/^[0-9]{12}$/'],
            'address' => 'nullable|string',
            'village' => 'nullable|string|max:100',
            'district' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'bank_name' => 'nullable|string|max:100',
            'account_holder_name' => 'nullable|string|max:255',
            'account_number' => ['nullable', 'string', 'regex:/^[0-9]{9,18}$/'],
            'ifsc_code' => ['nullable', 'string', 'regex:/^[A-Za-z]{4}0[A-Za-z0-9]{6}$/'],
            'aadhar_front' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'aadhar_back' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'pan_card' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'land_certificate' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
        ];

        $messages = [
            'aadhar_number.regex' => 'Aadhaar number must be a valid 12-digit numeric number.',
            'account_number.regex' => 'Account number must be between 9 and 18 digits.',
            'ifsc_code.regex' => 'IFSC code must be an 11-character valid code (e.g. SBIN0001234).',
        ];

        $request->validate($rules, $messages);

        $farmer = Farmer::where('user_id', Auth::id())->first();
        if (!$farmer) {
            $farmer = new Farmer();
            $farmer->user_id = Auth::id();
            $farmer->full_name = Auth::user()->name;
        }

        if ($request->has('dob') && $request->dob) $farmer->dob = $request->dob;
        if ($request->has('aadhar_number') && $request->aadhar_number) $farmer->aadhar_number = $request->aadhar_number;
        if ($request->has('address') && $request->address) $farmer->address = $request->address;
        if ($request->has('village') && $request->village) $farmer->village = $request->village;
        if ($request->has('district') && $request->district) $farmer->district = $request->district;
        if ($request->has('state') && $request->state) $farmer->state = $request->state;
        if ($request->has('bank_name') && $request->bank_name) $farmer->bank_name = $request->bank_name;
        if ($request->has('account_holder_name') && $request->account_holder_name) $farmer->account_holder_name = $request->account_holder_name;
        if ($request->has('account_number') && $request->account_number) $farmer->account_number = $request->account_number;
        if ($request->has('ifsc_code') && $request->ifsc_code) $farmer->ifsc_code = $request->ifsc_code;

        if ($request->hasFile('aadhar_front')) {
            $farmer->aadhar_front_path = $request->file('aadhar_front')->store('farmers/documents', 'public');
        }
        if ($request->hasFile('aadhar_back')) {
            $farmer->aadhar_back_path = $request->file('aadhar_back')->store('farmers/documents', 'public');
        }
        if ($request->hasFile('pan_card')) {
            $farmer->pan_card_path = $request->file('pan_card')->store('farmers/documents', 'public');
        }
        if ($request->hasFile('land_certificate')) {
            $farmer->land_certificate_path = $request->file('land_certificate')->store('farmers/documents', 'public');
        }

        $farmer->overall_status = 'pending';
        $farmer->save();

        return redirect()->back()->with('success', 'Your profile details and verification documents have been updated and submitted for admin review.');
    }
}
