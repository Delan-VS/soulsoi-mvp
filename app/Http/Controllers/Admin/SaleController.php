<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Farm;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'farm_id' => 'required|exists:farms,id',
            'buyer_name' => 'required|string|max:255',
            'sale_amount' => 'required|numeric|min:0',
            'quantity_sold' => 'required|numeric|min:0',
            'sale_date' => 'required|date',
            'invoice' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $sale = new Sale();
        $sale->farm_id = $request->farm_id;
        $sale->buyer_name = $request->buyer_name;
        $sale->sale_amount = $request->sale_amount;
        $sale->quantity_sold = $request->quantity_sold;
        $sale->sale_date = $request->sale_date;
        $sale->status = 'pending'; // Default status

        // Handle invoice upload if provided
        if ($request->hasFile('invoice')) {
            $path = $request->file('invoice')->store('invoices', 'public');
            $sale->invoice_path = $path;
        }

        // Dummy compliance checks based on farm state
        $farm = Farm::find($request->farm_id);
        if ($farm) {
            $sale->compliance_blockchain = $farm->verification_status === 'approved' ? true : false;
            $sale->compliance_audit = true; // Hardcoded for simplicity
            $sale->compliance_pesticide_free = strtolower($farm->farming_type ?? '') === 'organic';
            
            if ($sale->compliance_blockchain) {
                // Generate a dummy hash
                $sale->blockchain_tx_hash = '0x' . substr(md5(uniqid()), 0, 40);
            }
        }

        $sale->save();

        return back()->withFragment('sales-proof')->with('success', 'Sale recorded successfully.');
    }

    public function verify(Sale $sale)
    {
        $sale->update(['status' => 'verified']);
        return back()->withFragment('sales-proof')->with('success', 'Sale verified successfully.');
    }

    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'buyer_name' => 'required|string|max:255',
            'sale_amount' => 'required|numeric|min:0',
            'quantity_sold' => 'required|numeric|min:0',
            'sale_date' => 'required|date',
            'status' => 'required|in:pending,verified,rejected',
            'invoice' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $sale->buyer_name = $request->buyer_name;
        $sale->sale_amount = $request->sale_amount;
        $sale->quantity_sold = $request->quantity_sold;
        $sale->sale_date = $request->sale_date;
        $sale->status = $request->status;

        if ($request->hasFile('invoice')) {
            $path = $request->file('invoice')->store('invoices', 'public');
            $sale->invoice_path = $path;
        }

        $sale->save();

        return back()->withFragment('sales-proof')->with('success', 'Sale updated successfully.');
    }

    public function destroy(Sale $sale)
    {
        $sale->delete();
        return back()->withFragment('sales-proof')->with('success', 'Sale deleted successfully.');
    }
}
