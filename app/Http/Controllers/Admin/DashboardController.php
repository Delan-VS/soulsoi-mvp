<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Farmer;
use App\Models\Farm;
use App\Models\User;
use App\Models\Investment;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        // Admin metrics
        $pendingFarmers = Farmer::where('overall_status', 'pending')->count();
        $approvedFarmers = Farmer::where('overall_status', 'approved')->count();
        $totalFarmers = Farmer::count();

        $pendingFarms = Farm::where('status', 'pending')->count();
        $approvedFarms = Farm::where('status', 'approved')->count();
        $totalFarms = Farm::count();
        $totalAcres = Farm::sum('total_acres');

        $totalInvestedCapital = Farm::sum('funding_raised');
        $totalFundingTarget = Farm::sum('funding_target');

        $recentFarmers = Farmer::with('user')->latest()->take(5)->get();
        $recentFarms = Farm::with('farmer.user')->latest()->take(5)->get();
        
        // All investments for Admin Approval Queue
        $allInvestments = Investment::with('user', 'farm')->latest()->get();
        $pendingInvestmentsCount = Investment::where('status', 'pending')->count();
        
        // All farms query for Harvest Management & Admin overview
        $allFarms = Farm::with(['farmer.user', 'updates', 'harvests'])->get();
        
        // Farmer data
        $myFarms = collect([]);
        $salesAndProofs = collect([]);
        $myFarmInvestments = collect([]);
        if ($user?->farmer) {
            $myFarms = Farm::where('farmer_id', $user->farmer->id)->with(['updates', 'harvests'])->get();
            if (class_exists('\App\Models\Sale')) {
                $salesAndProofs = \App\Models\Sale::whereHas('farm', function($q) use ($user) {
                    $q->where('farmer_id', $user->farmer->id);
                })->latest()->get();
            }
            if (class_exists('\App\Models\Investment')) {
                $myFarmInvestments = \App\Models\Investment::whereHas('farm', function($q) use ($user) {
                    $q->where('farmer_id', $user->farmer->id);
                })->with(['user', 'farm'])->latest()->get();
            }
        }
        
        // Investor data
        $availableFarms = Farm::where('status', 'approved')->with(['updates', 'harvests'])->get();
            
        $myInvestments = collect([]);
        if (class_exists('\App\Models\Investment')) {
            $myInvestments = \App\Models\Investment::where('user_id', $user?->id)
                ->with(['farm.farmer'])
                ->get()
                ->unique('farm_id');
        }

        // Investor Accounts Queue (User Approvals)
        $allInvestorUsers = User::whereIn('investor_status', ['pending', 'approved', 'rejected'])->latest()->get();
        $pendingInvestorUsersCount = User::where('investor_status', 'pending')->count();

        return view('admin.dashboard', compact(
            'pendingFarmers', 'approvedFarmers', 'totalFarmers',
            'pendingFarms', 'approvedFarms', 'totalFarms', 'totalAcres',
            'totalInvestedCapital', 'totalFundingTarget',
            'recentFarmers', 'recentFarms',
            'allInvestments', 'pendingInvestmentsCount',
            'allInvestorUsers', 'pendingInvestorUsersCount',
            'myFarms', 'availableFarms', 'myInvestments', 'allFarms', 'salesAndProofs', 'myFarmInvestments'
        ));
    }

    public function approveInvestorUser(User $user)
    {
        $user->update(['investor_status' => 'approved']);
        return redirect()->route('admin.dashboard', ['tab' => 'investors'])->with('success', 'Investor account for ' . $user->name . ' (' . $user->email . ') has been approved successfully.');
    }

    public function rejectInvestorUser(User $user)
    {
        $user->update(['investor_status' => 'rejected']);
        return redirect()->route('admin.dashboard', ['tab' => 'investors'])->with('success', 'Investor account for ' . $user->name . ' has been rejected.');
    }

    public function approveInvestment(Investment $investment)
    {
        $investment->update(['status' => 'approved']);

        // Update farm metrics upon investment approval
        if ($farm = $investment->farm) {
            $farm->increment('funding_raised', $investment->amount);
            $farm->increment('investor_count', 1);

            if ($farm->funding_target > 0 && $farm->funding_raised >= $farm->funding_target) {
                $farm->update(['funding_status' => 'closed']);
            }
        }

        return redirect()->route('admin.dashboard', ['tab' => 'investors'])->with('success', 'Investment of ₹' . number_format($investment->amount) . ' has been approved successfully.');
    }

    public function storeInvestment(Request $request)
    {
        $request->validate([
            'farm_id' => 'required|exists:farms,id',
            'amount' => 'required|numeric|min:100',
            'payment_method' => 'nullable|string',
        ]);

        $farm = Farm::findOrFail($request->farm_id);
        $amount = $request->amount;
        $target = ($farm->funding_target > 0) ? $farm->funding_target : 350000;
        $equity = min(100, round(($amount / $target) * 100, 2));

        $investment = new Investment();
        $investment->user_id = auth()->id();
        $investment->farm_id = $farm->id;
        $investment->amount = $amount;
        $investment->equity_share = $equity;
        $investment->status = 'pending';
        if (\Illuminate\Support\Facades\Schema::hasColumn('investments', 'payment_method')) {
            $investment->payment_method = $request->input('payment_method', 'UPI');
        }
        $investment->save();

        return redirect(route('admin.dashboard') . '#investments')->with('success', 'Investment pledge of ₹' . number_format($amount) . ' submitted successfully! Awaiting admin payment verification.');
    }

    public function rejectInvestment(Investment $investment)
    {
        $investment->update(['status' => 'rejected']);

        return redirect()->route('admin.dashboard', ['tab' => 'investors'])->with('success', 'Investment application has been rejected.');
    }

    public function exportReport(Request $request)
    {
        $type = $request->query('type', 'farms');
        
        $headers = [
            'Content-type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="export_'.$type.'.csv"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0'
        ];

        $callback = function() use($type) {
            $file = fopen('php://output', 'w');
            
            if ($type === 'farms') {
                fputcsv($file, ['ID', 'Farm Name', 'Farmer', 'Location', 'Total Acres', 'Status', 'Funding Raised']);
                $farms = Farm::with('farmer.user')->get();
                foreach ($farms as $farm) {
                    fputcsv($file, [
                        $farm->id,
                        $farm->farm_name,
                        $farm->farmer && $farm->farmer->user ? $farm->farmer->user->name : 'N/A',
                        $farm->location,
                        $farm->total_acres,
                        $farm->status,
                        $farm->funding_raised
                    ]);
                }
            } elseif ($type === 'farmers') {
                fputcsv($file, ['ID', 'Full Name', 'Email', 'Phone', 'District', 'State', 'Bank Name', 'Account Number', 'Status']);
                $farmers = Farmer::with('user')->get();
                foreach ($farmers as $farmer) {
                    fputcsv($file, [
                        $farmer->id,
                        $farmer->full_name ?? ($farmer->user ? $farmer->user->name : 'N/A'),
                        $farmer->user ? $farmer->user->email : 'N/A',
                        $farmer->user ? $farmer->user->phone : 'N/A',
                        $farmer->district,
                        $farmer->state,
                        $farmer->bank_name,
                        $farmer->account_number,
                        $farmer->overall_status
                    ]);
                }
            } else {
                fputcsv($file, ['Message'], ['Unsupported export type.']);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
