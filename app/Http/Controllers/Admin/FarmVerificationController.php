<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Farm;

class FarmVerificationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Step 1: Basic Details
            'name' => 'required|string|max:255',
            'total_acres' => 'required|numeric',
            'primary_crop' => 'required|string|max:255',
            'secondary_crop' => 'nullable|string|max:255',
            'listing_category' => 'required|string',
            
            // Step 2: Investment
            'budget_breakdown' => 'nullable|string', // JSON string from hidden input
            'funding_target' => 'required|numeric',
            'expected_roi' => 'required|numeric',
            
            // Step 3: Media
            'farm_photos.*' => 'nullable|image|max:5120', // max 5MB
            'farm_documents.*' => 'nullable|mimes:pdf|max:10240', // max 10MB
            
            // Step 4: Yield
            'yielding_period' => 'required|integer',
            'expected_start_date' => 'required|date',
            'farming_timeline' => 'nullable|string', // JSON string from hidden input
            
            // Step 5: Terms
            'min_investment' => 'required|numeric',
            'max_investment' => 'required|numeric',
        ]);

        $farm = new Farm();
        
        // Handle Farmer ID (ensure farmer exists)
        if (!auth()->user()->farmer) {
            return back()->with('error', 'You must complete your farmer profile before adding a farm.');
        }
        $farm->farmer_id = auth()->user()->farmer->id;
        
        // Basic Details
        $farm->name = $validated['name'];
        $farm->total_acres = $validated['total_acres'];
        $farm->primary_crop = $validated['primary_crop'];
        $farm->secondary_crop = $validated['secondary_crop'] ?? null;
        $farm->listing_category = $validated['listing_category'];
        
        // Investment
        $farm->funding_target = $validated['funding_target'];
        $farm->expected_roi = $validated['expected_roi'];
        $budgetRaw = $validated['budget_breakdown'] ?? $request->input('budget_breakdown');
        $farm->budget_breakdown = !empty($budgetRaw) ? (is_array($budgetRaw) ? $budgetRaw : json_decode($budgetRaw, true)) : [];
        
        // Yield
        $farm->yielding_period = $validated['yielding_period'];
        $farm->expected_start_date = $validated['expected_start_date'];
        $timelineRaw = $validated['farming_timeline'] ?? $request->input('farming_timeline');
        $farm->farming_timeline = !empty($timelineRaw) ? (is_array($timelineRaw) ? $timelineRaw : json_decode($timelineRaw, true)) : [];
        
        // Terms
        $farm->min_investment = $validated['min_investment'];
        $farm->max_investment = $validated['max_investment'];
        
        // Media Uploads
        $photoPaths = [];
        if ($request->hasFile('farm_photo')) {
            $farm->farm_photo_path = $request->file('farm_photo')->store('farms/photos', 'public');
            $photoPaths[] = $farm->farm_photo_path;
        }

        if ($request->hasFile('farm_photos')) {
            foreach ($request->file('farm_photos') as $photo) {
                $path = $photo->store('farms/photos', 'public');
                $photoPaths[] = $path;
            }
            if (!$farm->farm_photo_path && count($photoPaths) > 0) {
                $farm->farm_photo_path = $photoPaths[0];
            }
        }
        $farm->additional_photos = $photoPaths;

        $docPaths = [];
        if ($request->hasFile('farm_documents')) {
            foreach ($request->file('farm_documents') as $doc) {
                $docPaths[] = $doc->store('farms/documents', 'public');
            }
        }
        $farm->additional_documents = $docPaths;

        if (auth()->user()->is_admin) {
            // Admin creations are approved immediately
            $farm->status = 'approved';
            if (\Illuminate\Support\Facades\Schema::hasColumn('farms', 'funding_status')) {
                $farm->funding_status = 'open';
            }
        } else {
            // Regular farmer submissions stay pending for admin review
            $farm->status = 'pending';
            if (\Illuminate\Support\Facades\Schema::hasColumn('farms', 'funding_status')) {
                $farm->funding_status = 'closed';
            }
        }
        $farm->save();

        return redirect(route('admin.dashboard') . '#my-farms')->with('success', 'Farm application submitted successfully and is pending review.');
    }

    public function index()
    {
        $farms = Farm::with('farmer.user')->latest()->paginate(15);
        return view('admin.farms.index', compact('farms'));
    }

    public function show(Farm $farm)
    {
        return view('admin.farms.show', compact('farm'));
    }

    public function edit(Farm $farm)
    {
        if (!auth()->user()->is_admin && auth()->user()->farmer?->id !== $farm->farmer_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('admin.farms.edit', compact('farm'));
    }

    public function update(Request $request, Farm $farm)
    {
        if (!auth()->user()->is_admin && auth()->user()->farmer?->id !== $farm->farmer_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'primary_crop' => 'required|string|max:255',
            'secondary_crop' => 'nullable|string|max:255',
            'total_acres' => 'required|numeric',
            'funding_target' => 'required|numeric',
            'your_contribution' => 'nullable|numeric',
            'expected_roi' => 'required|numeric',
            'yielding_period' => 'required|integer',
            'expected_start_date' => 'nullable|date',
            'min_investment' => 'required|numeric',
            'max_investment' => 'required|numeric',
            'listing_category' => 'nullable|string',
            'soil_ph' => 'nullable|string|max:50',
            'npk_ratio' => 'nullable|string|max:50',
            'avg_rainfall' => 'nullable|string|max:50',
            'temp_range' => 'nullable|string|max:50',
            'farm_photo' => 'nullable|image|max:5120',
            'farm_photos.*' => 'nullable|image|max:5120',
            'farm_documents.*' => 'nullable|mimes:pdf|max:10240',
        ]);

        $farm->fill($validated);

        if ($request->has('status') && auth()->user()->is_admin) {
            $farm->status = $request->status;
        }

        if ($request->has('funding_status') && auth()->user()->is_admin) {
            $farm->funding_status = $request->funding_status;
        }

        // Handle single cover photo upload
        if ($request->hasFile('farm_photo')) {
            $farm->farm_photo_path = $request->file('farm_photo')->store('farms/photos', 'public');
        }

        // Handle additional photos
        if ($request->hasFile('farm_photos')) {
            $photoPaths = $farm->additional_photos ?? [];
            foreach ($request->file('farm_photos') as $photo) {
                $photoPaths[] = $photo->store('farms/photos', 'public');
            }
            $farm->additional_photos = $photoPaths;
        }

        // Handle additional documents
        if ($request->hasFile('farm_documents')) {
            $docPaths = $farm->additional_documents ?? [];
            foreach ($request->file('farm_documents') as $doc) {
                $docPaths[] = $doc->store('farms/documents', 'public');
            }
            $farm->additional_documents = $docPaths;
        }

        $farm->save();

        return redirect(route('admin.dashboard') . '#my-farms')->with('success', 'Farm plot updated successfully!');
    }

    public function destroy(Farm $farm)
    {
        if (!auth()->user()->is_admin && auth()->user()->farmer?->id !== $farm->farmer_id) {
            abort(403, 'Unauthorized action.');
        }

        $farm->delete();

        return redirect(route('admin.dashboard') . '#my-farms')->with('success', 'Farm plot deleted successfully.');
    }

    public function approve(Farm $farm)
    {
        $farm->update([
            'status' => 'approved',
            'funding_status' => 'open',
            'reviewed_by_id' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Farm application approved successfully. Funding is now open!');
    }

    public function reject(Request $request, Farm $farm)
    {
        $farm->update([
            'status' => 'rejected',
            'funding_status' => 'closed',
            'reviewed_by_id' => auth()->id(),
            'reviewed_at' => now(),
            'admin_notes' => $request->input('admin_notes', 'Rejected by administrator.'),
        ]);

        return back()->with('success', 'Farm application rejected.');
    }

    public function stopCollecting(Farm $farm)
    {
        $farm->update([
            'funding_status' => 'closed',
            'status' => 'approved',
        ]);

        return back()->with('success', 'Stopped collecting funds for ' . $farm->name . '. Funding status is now CLOSED.');
    }

    public function settle(Farm $farm)
    {
        $farm->update([
            'status' => 'completed',
        ]);

        return back()->with('success', 'Settlement submitted successfully. The farm cycle is now completed.');
    }

    public function disburse(Request $request, Farm $farm)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'stage' => 'required|string|max:255',
            'purpose' => 'nullable|string',
        ]);

        // If submitted by Admin, directly disburse; if submitted by Farmer, mark as pending_disbursement
        if (auth()->user()->is_admin) {
            $farm->increment('funding_raised', $request->amount);
            $farm->update([
                'pending_disbursement_amount' => 0,
                'pending_disbursement_stage' => null,
                'pending_disbursement_purpose' => null,
            ]);

            return back()->with('success', '₹' . number_format($request->amount) . ' disbursed to ' . $farm->name . ' successfully!');
        }

        $farm->update([
            'pending_disbursement_amount' => $request->amount,
            'pending_disbursement_stage' => $request->stage,
            'pending_disbursement_purpose' => $request->purpose,
        ]);

        return back()->with('success', 'Fund disbursement request of ₹' . number_format($request->amount) . ' submitted for Admin review.');
    }

    public function approveDisbursement(Farm $farm)
    {
        $amount = $farm->pending_disbursement_amount ?? 0;
        
        $farm->increment('funding_raised', $amount);
        $farm->update([
            'pending_disbursement_amount' => 0,
            'pending_disbursement_stage' => null,
            'pending_disbursement_purpose' => null,
        ]);

        return back()->with('success', 'Fund request approved! ₹' . number_format($amount) . ' disbursed to ' . $farm->name . '.');
    }

    public function rejectDisbursement(Farm $farm)
    {
        $farm->update([
            'pending_disbursement_amount' => 0,
            'pending_disbursement_stage' => null,
            'pending_disbursement_purpose' => null,
        ]);

        return back()->with('success', 'Fund disbursement request rejected.');
    }
}
