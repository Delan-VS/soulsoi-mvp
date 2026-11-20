<?php

namespace App\Http\Controllers;

use App\Models\Farm;
use App\Models\Investment;
use Illuminate\Http\Request;

class InvestorController extends Controller
{
    public function showFarm(Farm $farm)
    {
        $existingInvestment = Investment::where('user_id', auth()->id())
            ->where('farm_id', $farm->id)
            ->first();

        return view('investor.farms.show', compact('farm', 'existingInvestment'));
    }

    public function invest(Request $request, Farm $farm)
    {
        if ($farm->funding_status === 'closed' || $farm->status === 'completed') {
            return back()->with('error', 'This farm cycle has reached 100% funding and is currently closed to new investment pledges.');
        }

        $minVal = $farm->min_investment ?? 500;
        $maxVal = $farm->max_investment ?? 10000000;
        $request->validate([
            'amount' => "required|numeric|min:{$minVal}|max:{$maxVal}",
            'payment_method' => 'nullable|string',
        ]);

        $currentRaised = max($farm->funding_raised ?? 0, $farm->investments ? $farm->investments->whereIn('status', ['approved', 'active'])->sum('amount') : 0);
        $remainingTarget = ($farm->funding_target ?? 350000) - $currentRaised;

        if ($remainingTarget <= 0) {
            $farm->update(['funding_status' => 'closed']);
            return back()->with('error', 'This farm is fully funded and cannot accept further investments.');
        }

        if ($request->amount > $remainingTarget) {
            return back()->with('error', 'Amount exceeds the remaining funding target of ₹' . number_format($remainingTarget));
        }

        $target = ($farm->funding_target > 0) ? $farm->funding_target : 350000;
        $equityShare = min(100, round(($request->amount / $target) * 100, 2));

        $investmentData = [
            'user_id' => auth()->id(),
            'farm_id' => $farm->id,
            'amount' => $request->amount,
            'equity_share' => $equityShare,
            'status' => 'pending',
        ];

        if (\Illuminate\Support\Facades\Schema::hasColumn('investments', 'payment_method')) {
            $investmentData['payment_method'] = $request->payment_method ?? 'UPI';
        }

        $investment = Investment::create($investmentData);

        $payMethodName = match (strtolower($request->payment_method ?? 'upi')) {
            'upi' => 'UPI Payment',
            'net_banking' => 'Net Banking',
            'bank_transfer' => 'Bank Transfer (NEFT/RTGS)',
            'card' => 'Credit / Debit Card',
            default => 'UPI Payment'
        };

        return redirect()->route('investor.portfolio.track', $farm->id)
            ->with('investment_success', true)
            ->with('investment_id', 'SS-INV-' . str_pad($investment->id, 4, '0', STR_PAD_LEFT))
            ->with('invest_amount', $request->amount)
            ->with('pay_method', $payMethodName)
            ->with('expected_harvest', now()->addMonths($farm->yielding_period ?? 6)->format('F Y'))
            ->with('success', 'Your investment of ₹' . number_format($request->amount) . ' via ' . $payMethodName . ' in ' . $farm->name . ' has been recorded successfully.');
    }

    public function trackInvestment(Farm $farm)
    {
        // 1. Fetch investment: if current user has an investment in this farm, use it
        $investment = Investment::where('user_id', auth()->id())
            ->where('farm_id', $farm->id)
            ->first();

        $isFarmerOwner = (auth()->user()?->farmer && (int)auth()->user()->farmer->id === (int)$farm->farmer_id);
        $isAdmin = (bool) auth()->user()?->is_admin;

        // If no user investment exists, but user is farm owner, admin, or inspecting the farm:
        // fall back to the first confirmed/active investment or aggregate farm figures
        if (!$investment) {
            $firstInv = Investment::where('farm_id', $farm->id)
                ->whereIn('status', ['approved', 'active'])
                ->first() ?: Investment::where('farm_id', $farm->id)->latest()->first();

            $farmRaised = (float) $farm->investments()->whereIn('status', ['approved', 'active'])->sum('amount');
            $capitalCommitted = $firstInv ? (float)$firstInv->amount : ($farmRaised > 0 ? $farmRaised : (float)($farm->funding_target ?? 350000));
            $equityShare = $firstInv ? (float)$firstInv->equity_share : 100.0;
            $invStatus = $firstInv ? $firstInv->status : ($farm->status === 'completed' ? 'settled' : ($farmRaised > 0 ? 'approved' : 'pending'));
            $invStartDate = $firstInv ? $firstInv->created_at : ($farm->created_at ?? now());
        } else {
            $capitalCommitted = (float) $investment->amount;
            $equityShare = (float) $investment->equity_share;
            $invStatus = $investment->status;
            $invStartDate = $investment->created_at;
        }

        // 2. Dynamic Real Stage Resolution
        $latestHarvest = $farm->harvests()
            ->where('status', '!=', 'gallery_photo')
            ->latest()
            ->first();
        $realHarvests = $farm->harvests()
            ->where('status', '!=', 'gallery_photo')
            ->get();
        $hasHarvestRecord = $realHarvests->count() > 0;

        // Actual Revenue from Harvest records
        $revEarned = $hasHarvestRecord
            ? (float) $realHarvests->sum(fn ($h) => $h->computedRevenue())
            : 0.0;

        // Actual Disbursed Expenses
        $expTotal = 0.0;
        if (!empty($farm->disbursement_history) && is_array($farm->disbursement_history)) {
            foreach ($farm->disbursement_history as $dItem) {
                if (str_contains(strtolower(trim($dItem['status'] ?? '')), 'disbursed')) {
                    $expTotal += (float) ($dItem['amount'] ?? 0);
                }
            }
        }

        $netProfit = $revEarned - $expTotal;

        // Stage mapping matching stepper: ['Land Prep', 'Sowing', 'Growing', 'Harvesting', 'Settled']
        if ($farm->status === 'completed' || $invStatus === 'settled') {
            $stageStatus = 'Settled';
        } elseif ($latestHarvest && $latestHarvest->status === 'harvested') {
            $stageStatus = 'Harvesting';
        } elseif ($latestHarvest && in_array($latestHarvest->status, ['in_progress', 'growing', 'ready'])) {
            $stageStatus = 'Growing';
        } elseif ($expTotal > 0 || ($farm->funding_raised ?? 0) >= ($farm->funding_target ?? 350000)) {
            $stageStatus = 'Growing';
        } elseif ($farm->status === 'approved' && (($farm->funding_raised ?? 0) > 0 || $invStatus === 'approved')) {
            $stageStatus = 'Sowing';
        } elseif ($invStatus === 'pending') {
            $stageStatus = 'Pending Approval';
        } else {
            $stageStatus = 'Land Prep';
        }

        // Expected & Actual returns
        $roiPercent = (float) ($farm->expected_roi ?? 18.0);
        $expectedReturns = round($capitalCommitted + ($capitalCommitted * ($roiPercent / 100)));

        $isSettled = ($farm->status === 'completed' || $invStatus === 'settled');
        $investorProfitCut = $netProfit > 0 ? round($netProfit * ($equityShare / 100)) : 0;
        $actualPayout = $isSettled ? ($capitalCommitted + $investorProfitCut) : $expectedReturns;
        $finalProfit = $isSettled ? ($actualPayout - $capitalCommitted) : ($expectedReturns - $capitalCommitted);

        // Timeline dates
        $startDate = $farm->start_date ? \Carbon\Carbon::parse($farm->start_date) : ($invStartDate ?? now());
        $expectedHarvestDate = $latestHarvest?->actual_harvest_date
            ? \Carbon\Carbon::parse($latestHarvest->actual_harvest_date)
            : ($farm->expected_harvest_date
                ? \Carbon\Carbon::parse($farm->expected_harvest_date)
                : $startDate->copy()->addMonths($farm->yielding_period ?? 6));

        $daysToHarvest = max(0, (int) now()->diffInDays($expectedHarvestDate, false));

        // Field Updates & Harvest Photos combined
        $updates = $farm->updates()->latest()->get()->map(function ($update) {
            return [
                'date' => $update->created_at->format('M d, Y'),
                'title' => $update->title,
                'description' => $update->description,
                'image' => $update->image_path ? asset('storage/' . $update->image_path) : null,
                'type' => 'field_update',
            ];
        })->toArray();

        // Also fetch harvest stage gallery photos
        $harvestPhotos = $farm->harvests()->whereNotNull('image_path')->latest()->get()->map(function ($h) {
            return [
                'date' => $h->created_at->format('M d, Y'),
                'title' => 'Harvest Milestone: ' . ucfirst($h->stage ?? $h->status ?? 'Crop Growth'),
                'description' => $h->notes ?? ('Yield verification photo recorded at ' . ($h->market_name ?? 'farm site')),
                'image' => asset('storage/' . $h->image_path),
                'type' => 'harvest_milestone',
            ];
        })->toArray();

        $allUpdates = array_merge($updates, $harvestPhotos);

        $investmentDetails = [
            'capital_committed' => $capitalCommitted,
            'equity_share' => number_format($equityShare, 1) . '%',
            'expected_roi' => $roiPercent . '%',
            'expected_returns' => $expectedReturns,
            'status' => $stageStatus,
            'is_pending' => $invStatus === 'pending',
            'timeline' => [
                'start_date' => $startDate->format('M d, Y'),
                'expected_harvest' => $expectedHarvestDate->format('M d, Y'),
                'days_to_harvest' => $daysToHarvest,
            ],
            'updates' => $allUpdates,
            'is_settled' => $isSettled,
            'final_profit' => $finalProfit,
            'actual_payout' => $actualPayout,
            'revenue_earned' => $revEarned,
            'expenses_total' => $expTotal,
            'net_profit' => $netProfit,
            'latest_harvest' => $latestHarvest,
            'real_harvests' => $realHarvests,
            'is_farmer_or_admin' => $isFarmerOwner || $isAdmin,
        ];

        return view('investor.portfolio.track', compact('farm', 'investmentDetails'));
    }
}
