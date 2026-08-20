<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Harvest;
use Illuminate\Http\Request;

class HarvestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'farm_id' => 'required|exists:farms,id',
            'status' => 'required|string',
            'estimated_yield' => 'nullable|numeric',
            'actual_yield' => 'nullable|numeric',
            'market_value' => 'nullable|numeric',
            'quality_grade' => 'nullable|string',
            'expected_harvest_date' => 'nullable|date',
            'actual_harvest_date' => 'nullable|date',
            'image' => 'nullable|image|max:5120',
        ]);

        $data = $request->only([
            'farm_id', 'status', 'estimated_yield', 'actual_yield',
            'market_value', 'quality_grade', 'expected_harvest_date', 'actual_harvest_date'
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('harvests', 'public');
        }

        Harvest::create($data);

        return redirect(url()->previous())->with('success', 'New harvest record logged successfully.');
    }

    public function update(Request $request, Harvest $harvest)
    {
        $request->validate([
            'status' => 'required|string',
            'estimated_yield' => 'nullable|numeric',
            'actual_yield' => 'nullable|numeric',
            'market_value' => 'nullable|numeric',
            'quality_grade' => 'nullable|string',
            'expected_harvest_date' => 'nullable|date',
            'actual_harvest_date' => 'nullable|date',
            'image' => 'nullable|image|max:5120',
        ]);

        $data = $request->only([
            'status', 'estimated_yield', 'actual_yield',
            'market_value', 'quality_grade', 'expected_harvest_date', 'actual_harvest_date'
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('harvests', 'public');
        }

        $harvest->update($data);

        return redirect(url()->previous())->with('success', 'Harvest details updated successfully.');
    }
    
    public function destroy(Harvest $harvest)
    {
        $harvest->delete();
        return redirect(url()->previous())->with('success', 'Harvest deleted successfully.');
    }
}
