<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Farmer;

class FarmerVerificationController extends Controller
{
    public function index()
    {
        $farmers = Farmer::latest()->paginate(10);
        return view('admin.farmers.index', compact('farmers'));
    }

    public function create()
    {
        return view('admin.farmers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
        ]); 

        // Create the user first
        $user = \App\Models\User::create([
            'name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => bcrypt('password123'), // Default password
            'role' => 'farmer',
        ]);

        $farmer = new Farmer();
        $farmer->user_id = $user->id; 
        $farmer->full_name = $validated['full_name'];
        $farmer->address = $validated['address'];
        $farmer->overall_status = 'pending';
        // Need to provide dummy values for required fields not in form
        $farmer->dob = now()->subYears(30);
        $farmer->aadhar_number = '000000000000';
        $farmer->village = 'N/A';
        $farmer->district = 'N/A';
        $farmer->state = 'N/A';
        $farmer->save();

        return redirect()->route('admin.farmers.index')->with('success', 'Farmer created successfully and is pending approval.');
    }

    public function show(Farmer $farmer)
    {
        return view('admin.farmers.show', compact('farmer'));
    }

    public function approve(Farmer $farmer)
    {
        $farmer->update([
            'overall_status' => 'approved',
            'document_verification' => 'approved',
            'bank_verification' => 'approved',
            'reviewed_by_id' => auth()->id(),
            'reviewed_at' => now(),
        ]);
        return back()->with('success', 'Farmer approved successfully!');
    }

    public function reject(Request $request, Farmer $farmer)
    {
        $reason = $request->input('reason') ?? $request->input('admin_notes') ?? 'Documents or bank details did not meet the verification requirements. Please review your information, make necessary corrections, and re-submit for approval.';

        $farmer->update([
            'overall_status' => 'rejected',
            'document_verification' => 'rejected',
            'admin_notes' => $reason,
            'reviewed_by_id' => auth()->id(),
            'reviewed_at' => now(),
        ]);
        return back()->with('success', 'Farmer rejected successfully with reason recorded.');
    }

    public function download(Farmer $farmer, $encodedPath)
    {
        $path = base64_decode($encodedPath);
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            return \Illuminate\Support\Facades\Storage::disk('public')->response($path);
        }
        if (file_exists(storage_path('app/public/' . $path))) {
            return response()->download(storage_path('app/public/' . $path));
        }
        abort(404, 'Document file not found.');
    }

    public function exportPdf(Farmer $farmer)
    {
        $farmer->load(['user', 'farms', 'reviewedBy']);
        return view('admin.farmers.pdf', compact('farmer'));
    }
}
