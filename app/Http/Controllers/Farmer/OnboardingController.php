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
        return view('farmer.onboarding');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'experience_years' => 'required|integer|min:0',
        ]);

        Farmer::create([
            'user_id' => Auth::id(),
            'phone' => $request->phone,
            'address' => $request->address,
            'experience_years' => $request->experience_years,
            'overall_status' => 'pending',
            'id_proof_path' => null,
            'address_proof_path' => null,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Your farmer application has been submitted for admin approval!');
    }
}
