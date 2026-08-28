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
        $investment = Investment::where('user_id', auth()->id())
            ->where('farm_id', $farm->id)
            ->firstOrFail();

        // Calculate expected returns based on the actual investment
        $expectedReturns = $investment->amount + ($investment->amount * ($farm->expected_roi ?? 18) / 100);

        $investmentDetails = [
            'capital_committed' => $investment->amount,
            'equity_share' => number_format($investment->equity_share, 2) . '%',
            'expected_roi' => ($farm->expected_roi ?? '18') . '%',
            'expected_returns' => $expectedReturns,
            'status' => $investment->status === 'pending' ? 'Pending Approval' : ($farm->status === 'funded' ? 'Growing' : ($farm->status === 'completed' ? 'Settled' : 'Land Prep')),
            'is_pending' => $investment->status === 'pending',
            'timeline' => [
                'start_date' => $investment->created_at->format('M d, Y'),
                'expected_harvest' => now()->addMonths($farm->yielding_period ?? 6)->format('M d, Y'),
                'days_to_harvest' => (int) now()->diffInDays(now()->addMonths($farm->yielding_period ?? 6))
            ],
            'updates' => $farm->updates()->latest()->get()->map(function ($update) {
                return [
                    'date' => $update->created_at->format('M d, Y'),
                    'title' => $update->title,
                    'description' => $update->description,
                    'image' => $update->image_path ? asset('storage/' . $update->image_path) : null
                ];
            })->toArray(),
            'is_settled' => $investment->status === 'settled',
            'final_profit' => $investment->status === 'settled' ? ($expectedReturns - $investment->amount) : null,
            'payout_receipt' => null,
            'harvest_photos' => []
        ];

        return view('investor.portfolio.track', compact('farm', 'investmentDetails'));
    }
}
