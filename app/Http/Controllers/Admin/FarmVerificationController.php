<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreFarmRequest;
use App\Services\FarmFinancialsService;
use App\Models\Farm;
use App\Models\AuditLog;
use App\Models\Crop;

class FarmVerificationController extends Controller
{
    /**
     * Preview financials and benchmarks endpoint for real-time frontend calculation check.
     */
    public function previewFinancials(Request $request, FarmFinancialsService $financialsService)
    {
        $financials = $financialsService->calculate($request->all());
        return response()->json($financials);
    }

    /**
     * Store newly submitted farm registration with financial calculations and ROI audit tracking.
     */
    public function store(StoreFarmRequest $request, FarmFinancialsService $financialsService)
    {
        $validated = $request->validated();

        if (!auth()->user()->farmer && !auth()->user()->is_admin) {
            return back()->with('error', 'You must complete your farmer profile before adding a farm.');
        }

        // Process budget breakdown JSON
        $budgetRaw = $validated['budget_breakdown'] ?? $request->input('budget_breakdown');
        $budgetItems = !empty($budgetRaw) ? (is_array($budgetRaw) ? $budgetRaw : json_decode($budgetRaw, true)) : [];

        // Compute total budget from items if available, or fall back to input
        $computedBudget = 0.0;
        if (is_array($budgetItems) && count($budgetItems) > 0) {
            foreach ($budgetItems as $bItem) {
                $computedBudget += (float) ($bItem['amount'] ?? $bItem['cost'] ?? 0.0);
            }
        }
        $totalBudget = $computedBudget > 0.0 ? $computedBudget : (float) ($validated['total_budget'] ?? $request->input('funding_target', 0));
        $farmerStake = (float) ($validated['your_contribution'] ?? 0.0);

        // Run server-side financials calculation
        $financials = $financialsService->calculate([
            'total_budget' => $totalBudget,
            'farmer_stake' => $farmerStake,
            'expected_yield_kg' => (float) $validated['expected_yield_kg'],
            'selling_price_per_kg' => (float) $validated['selling_price_kg'],
            'total_acres' => (float) $validated['total_acres'],
            'crop_name' => $validated['primary_crop'],
            'crop_cycle_days' => $validated['crop_cycle_days'] ?? ((int) ($validated['yielding_period'] ?? 4) * 30),
            'yield_shortfall_percent' => $validated['yield_shortfall_percent'] ?? null,
        ]);

        $farm = new Farm();
        $farm->farmer_id = auth()->user()->farmer ? auth()->user()->farmer->id : 1;

        // Step 1: Basic Plot Details
        $farm->name = $validated['name'];
        $farm->total_acres = $validated['total_acres'];
        $farm->primary_crop = $validated['primary_crop'];
        $farm->secondary_crop = $validated['secondary_crop'] ?? null;
        $farm->location = $validated['location'] ?? null;
        $farm->listing_category = $validated['listing_category'];

        // Step 2: Investment & Capital Structure (Fix #2: Funding Target = Total Budget - Farmer Stake)
        $farm->total_budget = $financials['total_budget'];
        $farm->your_contribution = $financials['farmer_stake'];
        $farm->funding_target = $financials['investor_funding_target'];
        $farm->projected_yield_kg = $financials['expected_yield_kg'];
        $farm->projected_price_per_kg = $financials['selling_price_per_kg'];
        $farm->projected_revenue = $financials['gross_revenue'];
        $farm->projected_net_profit = $financials['net_profit'];
        $farm->investor_profit_share = $financials['investor_profit_share'];
        $farm->farmer_profit_share = $financials['farmer_profit_share'];
        $farm->crop_cycle_days = $financials['cycle_days'];
        $farm->calculated_roi = $financials['calculated_roi'];
        $farm->annualized_roi = $financials['annualized_roi'];
        $farm->yield_shortfall_percent = $financials['shortfall_percent'];
        $farm->budget_breakdown = $budgetItems;

        // Fix #4: Store Calculated ROI separately from Admin Override with Audit Log
        $isOverridden = filter_var($request->input('is_roi_overridden'), FILTER_VALIDATE_BOOLEAN)
            || $request->input('is_roi_overridden') === '1'
            || $request->input('is_roi_overridden') === 1;

        if ($isOverridden) {
            $farm->is_roi_overridden = true;
            $farm->expected_roi = (float) $validated['expected_roi'];
            $farm->roi_override_reason = $validated['roi_override_reason'] ?? 'Admin custom term adjustment';

            AuditLog::create([
                'user_name' => auth()->user()?->name ?? 'Admin',
                'action' => 'ROI Overridden',
                'description' => sprintf(
                    "ROI for farm '%s' was overridden from calculated %.2f%% to %.2f%%. Reason: %s",
                    $farm->name,
                    $farm->calculated_roi,
                    $farm->expected_roi,
                    $farm->roi_override_reason
                ),
                'ip_address' => $request->ip(),
            ]);
        } else {
            $farm->is_roi_overridden = false;
            $farm->expected_roi = $farm->calculated_roi;
            $farm->roi_override_reason = null;
        }

        // Step 3: Yield & Farming Timeline
        $farm->yielding_period = $validated['yielding_period'];
        $farm->expected_start_date = $validated['expected_start_date'];
        $timelineRaw = $validated['farming_timeline'] ?? $request->input('farming_timeline');
        $farm->farming_timeline = !empty($timelineRaw) ? (is_array($timelineRaw) ? $timelineRaw : json_decode($timelineRaw, true)) : [];

        // Step 4: Terms & Limits
        $farm->min_investment = $validated['min_investment'];
        $farm->max_investment = $validated['max_investment'];

        // Step 5: Media Uploads
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

        // Admin submissions are approved immediately; farmer submissions stay pending
        if (auth()->user()->is_admin) {
            $farm->status = 'approved';
            $farm->funding_status = 'open';
        } else {
            $farm->status = 'pending';
            $farm->funding_status = 'closed';
        }

        $farm->save();

        // Flash benchmark warnings to session if any (Fix #5: non-blocking warning)
        if (!empty($financials['benchmark_warnings'])) {
            session()->flash('benchmark_warnings', $financials['benchmark_warnings']);
        }

        return redirect(route('admin.dashboard') . '#my-farms')
            ->with('success', sprintf(
                "Farm plot '%s' registered successfully with an Investor Funding Target of ₹%s (Total Budget: ₹%s, Farmer Stake: ₹%s) and %.1f%% %s.",
                $farm->name,
                number_format($farm->funding_target),
                number_format($farm->total_budget),
                number_format($farm->your_contribution),
                $farm->expected_roi,
                $farm->is_roi_overridden ? 'Overridden ROI' : 'Calculated ROI'
            ))
            ->with('submitted_farm_id', $farm->id);
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

        if ($request->hasFile('farm_photo')) {
            $farm->farm_photo_path = $request->file('farm_photo')->store('farms/photos', 'public');
        }

        if ($request->hasFile('farm_photos')) {
            $photoPaths = $farm->additional_photos ?? [];
            foreach ($request->file('farm_photos') as $photo) {
                $photoPaths[] = $photo->store('farms/photos', 'public');
            }
            $farm->additional_photos = $photoPaths;
        }

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
        $outcome = \Illuminate\Support\Facades\DB::transaction(function () use ($farm) {
            $lockedFarm = Farm::whereKey($farm->id)->lockForUpdate()->firstOrFail();

            if ($lockedFarm->status === 'completed') {
                return ['status' => 'already_finalized'];
            }

            $confirmedInvestment = (float) $lockedFarm->investments()
                ->whereIn('status', ['approved', 'active'])
                ->sum('amount');
            $requiredFunding = (float) ($lockedFarm->funding_target ?? 0);
            $isFunded = $confirmedInvestment > 0 || $lockedFarm->status === 'approved' || ($requiredFunding <= 0);

            $hasHarvest = $lockedFarm->harvests()
                ->where('status', '!=', 'gallery_photo')
                ->exists();

            if (!$hasHarvest) {
                return [
                    'status' => 'error',
                    'message' => 'Cannot finalize settlement until at least one harvest record is logged.',
                ];
            }

            if (!$isFunded && $confirmedInvestment <= 0) {
                return [
                    'status' => 'error',
                    'message' => 'Cannot finalize settlement until the farm has confirmed investments.',
                ];
            }

            $updateData = ['status' => 'completed', 'funding_status' => 'closed'];
            $lockedFarm->update($updateData);

            return ['status' => 'finalized'];
        });

        if ($outcome['status'] === 'error') {
            return redirect(route('admin.farms.show', $farm->id) . '?tab=harvest#harvest')
                ->with('error', $outcome['message']);
        }

        $msg = $outcome['status'] === 'already_finalized'
            ? 'Settlement is already finalized for this farm.'
            : 'Settlement finalized successfully. The farm cycle is now completed.';

        return redirect(route('admin.farms.show', $farm->id) . '?tab=settlement#settlement')
            ->with('success', $msg);
    }

    public function disburse(Request $request, Farm $farm)
    {
        $isBatch = $request->boolean('is_batch') || $request->has('batch_items') || (is_array($request->input('batch_stages')) && count($request->input('batch_stages')) > 0);

        if ($isBatch) {
            $rawBatch = $request->input('batch_items');
            $batchItems = [];

            if (is_string($rawBatch)) {
                $decoded = json_decode($rawBatch, true);
                if (is_array($decoded)) {
                    $batchItems = $decoded;
                }
            } elseif (is_array($rawBatch)) {
                $batchItems = $rawBatch;
            } elseif (is_array($request->input('batch_stages'))) {
                $stageNames = $request->input('batch_stages');
                $amounts = (array)$request->input('batch_amounts', []);
                $purposes = (array)$request->input('batch_purposes', []);
                foreach ($stageNames as $idx => $sName) {
                    $batchItems[] = [
                        'stage' => $sName,
                        'amount' => (float)($amounts[$sName] ?? $amounts[$idx] ?? 0),
                        'purpose' => $purposes[$sName] ?? $purposes[$idx] ?? ('Budgeted disbursement for ' . $sName),
                    ];
                }
            }

            $batchItems = array_values(array_filter($batchItems, function ($item) {
                return !empty($item['stage']) && !empty($item['amount']) && (float)$item['amount'] > 0;
            }));

            if (empty($batchItems)) {
                return redirect()->to(route('admin.farms.show', $farm->id) . '?tab=fund-request#fund-request')->with('error', 'Please select at least one stage with a valid amount to disburse.');
            }

            $evidencePath = null;
            if ($request->hasFile('evidence_file')) {
                $evidencePath = $request->file('evidence_file')->store('farms/disbursements', 'public');
            }

            $history = $farm->disbursement_history ?? [];
            $totalAmount = 0;
            $stageTitles = [];

            if (auth()->user()->is_admin) {
                foreach ($batchItems as $item) {
                    $amt = (float)$item['amount'];
                    $totalAmount += $amt;
                    $stageTitles[] = $item['stage'];

                    $history[] = [
                        'amount' => $amt,
                        'stage' => $item['stage'],
                        'purpose' => $item['purpose'] ?? ('Direct admin disbursement for ' . $item['stage']),
                        'priority' => $request->input('priority', 'Standard (3-5 days)'),
                        'evidence_file' => $evidencePath,
                        'status' => 'Disbursed',
                        'date' => now()->format('Y-m-d H:i'),
                        'submitted_by' => auth()->user()->name . ' (Admin)'
                    ];
                }

                $remainingPendingAmount = 0;
                $remainingPendingStages = [];
                foreach ($history as $h) {
                    if (($h['status'] ?? '') === 'Pending Review') {
                        $remainingPendingAmount += (float)($h['amount'] ?? 0);
                        $remainingPendingStages[] = $h['stage'] ?? '';
                    }
                }

                $farm->update([
                    'pending_disbursement_amount' => $remainingPendingAmount,
                    'pending_disbursement_stage' => !empty($remainingPendingStages) ? implode(', ', array_unique(array_filter($remainingPendingStages))) : null,
                    'pending_disbursement_purpose' => !empty($remainingPendingStages) ? ('Pending requests for: ' . implode(', ', array_unique(array_filter($remainingPendingStages)))) : null,
                    'disbursement_history' => $history,
                ]);

                return redirect()->to(route('admin.farms.show', $farm->id) . '?tab=fund-request#fund-request')
                    ->with('success', '₹' . number_format($totalAmount) . ' disbursed across ' . count($batchItems) . ' stages (' . implode(', ', $stageTitles) . ') successfully!');
            }

            foreach ($batchItems as $item) {
                $amt = (float)$item['amount'];
                $totalAmount += $amt;
                $stageTitles[] = $item['stage'];

                $history[] = [
                    'amount' => $amt,
                    'stage' => $item['stage'],
                    'purpose' => $item['purpose'] ?? ('Budgeted disbursement request for ' . $item['stage']),
                    'priority' => $request->input('priority', 'Standard (3-5 days)'),
                    'evidence_file' => $evidencePath,
                    'status' => 'Pending Review',
                    'date' => now()->format('Y-m-d H:i'),
                    'submitted_by' => auth()->user()->name
                ];
            }

            $totalPending = 0;
            $allPendingStages = [];
            foreach ($history as $h) {
                if (($h['status'] ?? '') === 'Pending Review') {
                    $totalPending += (float)($h['amount'] ?? 0);
                    $allPendingStages[] = $h['stage'] ?? '';
                }
            }

            $farm->update([
                'pending_disbursement_amount' => $totalPending,
                'pending_disbursement_stage' => implode(', ', array_unique(array_filter($allPendingStages))),
                'pending_disbursement_purpose' => 'Batch request for ' . count($batchItems) . ' stages: ' . implode(', ', $stageTitles),
                'disbursement_history' => $history,
            ]);

            return redirect()->to(route('admin.farms.show', $farm->id) . '?tab=fund-request#fund-request')
                ->with('success', 'Batch fund request of ₹' . number_format($totalAmount) . ' for ' . count($batchItems) . ' stages submitted for Admin review.');
        }

        $request->validate([
            'amount' => 'required|numeric|min:1',
            'stage' => 'required|string|max:255',
            'purpose' => 'nullable|string',
            'evidence_file' => 'nullable|file|max:10240|mimes:pdf,jpg,jpeg,png',
        ]);

        $evidencePath = null;
        if ($request->hasFile('evidence_file')) {
            $evidencePath = $request->file('evidence_file')->store('farms/disbursements', 'public');
        }

        $history = $farm->disbursement_history ?? [];

        if (auth()->user()->is_admin) {
            $history[] = [
                'amount' => (float)$request->amount,
                'stage' => $request->stage,
                'purpose' => $request->purpose ?? 'Direct admin disbursement for ' . $request->stage,
                'priority' => $request->input('priority', 'Standard (3-5 days)'),
                'evidence_file' => $evidencePath,
                'status' => 'Disbursed',
                'date' => now()->format('Y-m-d H:i'),
                'submitted_by' => auth()->user()->name . ' (Admin)'
            ];

            $targetStageLower = strtolower(trim($request->stage));
            foreach ($history as &$hItem) {
                if (isset($hItem['status']) && $hItem['status'] === 'Pending Review') {
                    $itemStageLower = strtolower(trim($hItem['stage'] ?? ''));
                    if ($itemStageLower === $targetStageLower) {
                        $hItem['status'] = 'Disbursed';
                        $hItem['approved_at'] = now()->format('Y-m-d H:i');
                        break;
                    }
                }
            }
            unset($hItem);

            $remainingPendingAmount = 0;
            $remainingPendingStages = [];
            foreach ($history as $h) {
                if (($h['status'] ?? '') === 'Pending Review') {
                    $remainingPendingAmount += (float)($h['amount'] ?? 0);
                    $remainingPendingStages[] = $h['stage'] ?? '';
                }
            }

            $farm->update([
                'pending_disbursement_amount' => $remainingPendingAmount,
                'pending_disbursement_stage' => !empty($remainingPendingStages) ? implode(', ', array_unique(array_filter($remainingPendingStages))) : null,
                'pending_disbursement_purpose' => !empty($remainingPendingStages) ? ('Pending requests for: ' . implode(', ', array_unique(array_filter($remainingPendingStages)))) : null,
                'disbursement_history' => $history,
            ]);

            return redirect()->to(route('admin.farms.show', $farm->id) . '?tab=fund-request#fund-request')->with('success', '₹' . number_format($request->amount) . ' disbursed for ' . $request->stage . ' successfully!');
        }

        $history[] = [
            'amount' => (float)$request->amount,
            'stage' => $request->stage,
            'purpose' => $request->purpose ?? 'Budgeted disbursement request',
            'priority' => $request->input('priority', 'Standard (3-5 days)'),
            'evidence_file' => $evidencePath,
            'status' => 'Pending Review',
            'date' => now()->format('Y-m-d H:i'),
            'submitted_by' => auth()->user()->name
        ];

        $totalPending = 0;
        $allPendingStages = [];
        foreach ($history as $h) {
            if (($h['status'] ?? '') === 'Pending Review') {
                $totalPending += (float)($h['amount'] ?? 0);
                $allPendingStages[] = $h['stage'] ?? '';
            }
        }

        $farm->update([
            'pending_disbursement_amount' => $totalPending,
            'pending_disbursement_stage' => implode(', ', array_unique(array_filter($allPendingStages))),
            'pending_disbursement_purpose' => $request->purpose,
            'disbursement_history' => $history,
        ]);

        return redirect()->to(route('admin.farms.show', $farm->id) . '?tab=fund-request#fund-request')->with('success', 'Fund disbursement request of ₹' . number_format($request->amount) . ' submitted for Admin review.');
    }

    public function approveDisbursement(Farm $farm, Request $request)
    {
        $targetStage = $request->input('stage');
        $history = $farm->disbursement_history ?? [];
        $approvedAmount = 0;
        $approvedStages = [];

        if (!empty($targetStage) && $targetStage !== 'all') {
            $targetStageLower = strtolower(trim($targetStage));
            $found = false;
            foreach ($history as &$item) {
                if (isset($item['status']) && $item['status'] === 'Pending Review') {
                    $itemStageLower = strtolower(trim($item['stage'] ?? ''));
                    if ($itemStageLower === $targetStageLower || str_contains($itemStageLower, $targetStageLower) || str_contains($targetStageLower, $itemStageLower)) {
                        $item['status'] = 'Disbursed';
                        $item['approved_at'] = now()->format('Y-m-d H:i');
                        $approvedAmount += (float)($item['amount'] ?? 0);
                        $approvedStages[] = $item['stage'] ?? $targetStage;
                        $found = true;
                        break;
                    }
                }
            }
            unset($item);

            if (!$found) {
                $approvedAmount = (float)($farm->pending_disbursement_amount ?? 0);
                $approvedStages[] = $targetStage;
            }
        } else {
            foreach ($history as &$item) {
                if (isset($item['status']) && $item['status'] === 'Pending Review') {
                    $item['status'] = 'Disbursed';
                    $item['approved_at'] = now()->format('Y-m-d H:i');
                    $approvedAmount += (float)($item['amount'] ?? 0);
                    $approvedStages[] = $item['stage'] ?? 'Fund Request';
                }
            }
            unset($item);

            if ($approvedAmount == 0 && ($farm->pending_disbursement_amount ?? 0) > 0) {
                $approvedAmount = (float)$farm->pending_disbursement_amount;
                $approvedStages[] = $farm->pending_disbursement_stage ?? 'Tranche';
            }
        }

        $remainingPendingAmount = 0;
        $remainingPendingStages = [];
        foreach ($history as $h) {
            if (($h['status'] ?? '') === 'Pending Review') {
                $remainingPendingAmount += (float)($h['amount'] ?? 0);
                $remainingPendingStages[] = $h['stage'] ?? '';
            }
        }

        $farm->update([
            'pending_disbursement_amount' => $remainingPendingAmount,
            'pending_disbursement_stage' => !empty($remainingPendingStages) ? implode(', ', array_unique(array_filter($remainingPendingStages))) : null,
            'pending_disbursement_purpose' => !empty($remainingPendingStages) ? ('Pending requests for: ' . implode(', ', array_unique(array_filter($remainingPendingStages)))) : null,
            'disbursement_history' => $history,
        ]);

        $stageText = !empty($approvedStages) ? implode(', ', $approvedStages) : 'Tranche';
        return redirect()->to(route('admin.farms.show', $farm->id) . '?tab=fund-request#fund-request')
            ->with('success', 'Fund request approved! ₹' . number_format($approvedAmount) . ' disbursed for ' . $stageText . ' to ' . $farm->name . '.');
    }

    public function rejectDisbursement(Farm $farm, Request $request)
    {
        $targetStage = $request->input('stage');
        $history = $farm->disbursement_history ?? [];
        $rejectedStages = [];

        if (!empty($targetStage) && $targetStage !== 'all') {
            $targetStageLower = strtolower(trim($targetStage));
            foreach ($history as &$item) {
                if (isset($item['status']) && $item['status'] === 'Pending Review') {
                    $itemStageLower = strtolower(trim($item['stage'] ?? ''));
                    if ($itemStageLower === $targetStageLower || str_contains($itemStageLower, $targetStageLower) || str_contains($targetStageLower, $itemStageLower)) {
                        $item['status'] = 'Rejected';
                        $item['rejected_at'] = now()->format('Y-m-d H:i');
                        $rejectedStages[] = $item['stage'] ?? $targetStage;
                        break;
                    }
                }
            }
            unset($item);
        } else {
            foreach ($history as &$item) {
                if (isset($item['status']) && $item['status'] === 'Pending Review') {
                    $item['status'] = 'Rejected';
                    $item['rejected_at'] = now()->format('Y-m-d H:i');
                    $rejectedStages[] = $item['stage'] ?? 'Fund Request';
                }
            }
            unset($item);
        }

        $remainingPendingAmount = 0;
        $remainingPendingStages = [];
        foreach ($history as $h) {
            if (($h['status'] ?? '') === 'Pending Review') {
                $remainingPendingAmount += (float)($h['amount'] ?? 0);
                $remainingPendingStages[] = $h['stage'] ?? '';
            }
        }

        $farm->update([
            'pending_disbursement_amount' => $remainingPendingAmount,
            'pending_disbursement_stage' => !empty($remainingPendingStages) ? implode(', ', array_unique(array_filter($remainingPendingStages))) : null,
            'pending_disbursement_purpose' => !empty($remainingPendingStages) ? ('Pending requests for: ' . implode(', ', array_unique(array_filter($remainingPendingStages)))) : null,
            'disbursement_history' => $history,
        ]);

        $stageText = !empty($rejectedStages) ? implode(', ', $rejectedStages) : 'Request';
        return redirect()->to(route('admin.farms.show', $farm->id) . '?tab=fund-request#fund-request')
            ->with('success', 'Fund disbursement request for ' . $stageText . ' was rejected.');
    }
}
