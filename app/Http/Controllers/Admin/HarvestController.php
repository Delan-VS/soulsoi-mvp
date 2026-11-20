<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Harvest;
use Illuminate\Http\Request;

class HarvestController extends Controller
{
    public function store(Request $request)
    {
        $isGallery = $request->input('status') === 'gallery_photo';

        if ($isGallery) {
            $request->validate([
                'farm_id' => 'required|exists:farms,id',
                'harvest_stage' => 'required|string|max:100',
                'image' => 'required|image|max:5120',
            ]);

            $path = $request->file('image')->store('harvests', 'public');
            $stage = $request->input('harvest_stage');

            Harvest::updateOrCreate(
                [
                    'farm_id' => $request->farm_id,
                    'status' => 'gallery_photo',
                    'quality_grade' => $stage,
                ],
                [
                    'image_path' => $path,
                ]
            );

            return redirect(route('admin.farms.show', $request->farm_id) . '?tab=harvest#harvest')
                ->with('success', "Stage photo uploaded for {$stage} successfully.");
        }

        $isHarvested = $request->input('status') === 'harvested';

        $validated = $request->validate([
            'farm_id' => 'required|exists:farms,id',
            'harvest_id' => 'nullable|exists:harvests,id',
            'status' => 'required|in:not_started,in_progress,harvesting,harvested',
            'start_date' => 'required|date',
            'actual_harvest_date' => ($isHarvested ? 'required' : 'nullable') . '|date|after_or_equal:start_date',
            'estimated_yield' => 'required|numeric|min:0.01',
            'actual_yield' => 'required|numeric|' . ($isHarvested ? 'min:0.01' : 'min:0'),
            'selling_price' => 'required|numeric|' . ($isHarvested ? 'min:0.01' : 'min:0'),
            'quality_grade' => 'required|string|max:100',
            'market_name' => 'required|string|max:255',
            'expected_harvest_date' => 'nullable|date',
            'image' => 'nullable|image|max:5120',
        ]);

        $data = [
            'farm_id' => $validated['farm_id'],
            'status' => $validated['status'],
            'start_date' => $validated['start_date'],
            'actual_harvest_date' => $validated['actual_harvest_date'] ?? null,
            'expected_harvest_date' => $validated['expected_harvest_date'] ?? null,
            'estimated_yield' => $validated['estimated_yield'],
            'actual_yield' => $validated['actual_yield'],
            'selling_price' => $validated['selling_price'],
            'market_value' => round((float) $validated['actual_yield'] * (float) $validated['selling_price'], 2),
            'quality_grade' => $validated['quality_grade'],
            'market_name' => $validated['market_name'],
        ];

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('harvests', 'public');
        }

        if ($request->filled('harvest_id')) {
            $existing = Harvest::where('id', $request->harvest_id)
                ->where('farm_id', $validated['farm_id'])
                ->first();
            if ($existing) {
                $existing->update($data);
                return redirect(route('admin.farms.show', $validated['farm_id']) . '?tab=harvest#harvest')
                    ->with('success', 'Harvest record updated successfully.');
            }
        }

        Harvest::create($data);

        return redirect(route('admin.farms.show', $validated['farm_id']) . '?tab=harvest#harvest')
            ->with('success', 'Harvest record logged successfully.');
    }

    public function update(Request $request, Harvest $harvest)
    {
        $isHarvested = $request->input('status') === 'harvested';

        $validated = $request->validate([
            'status' => 'required|in:not_started,in_progress,harvesting,harvested',
            'start_date' => 'required|date',
            'actual_harvest_date' => ($isHarvested ? 'required' : 'nullable') . '|date|after_or_equal:start_date',
            'estimated_yield' => 'required|numeric|min:0.01',
            'actual_yield' => 'required|numeric|' . ($isHarvested ? 'min:0.01' : 'min:0'),
            'selling_price' => 'required|numeric|' . ($isHarvested ? 'min:0.01' : 'min:0'),
            'quality_grade' => 'required|string|max:100',
            'market_name' => 'required|string|max:255',
            'expected_harvest_date' => 'nullable|date',
            'image' => 'nullable|image|max:5120',
        ]);

        $data = [
            'status' => $validated['status'],
            'start_date' => $validated['start_date'],
            'actual_harvest_date' => $validated['actual_harvest_date'] ?? null,
            'expected_harvest_date' => $validated['expected_harvest_date'] ?? null,
            'estimated_yield' => $validated['estimated_yield'],
            'actual_yield' => $validated['actual_yield'],
            'selling_price' => $validated['selling_price'],
            'market_value' => round((float) $validated['actual_yield'] * (float) $validated['selling_price'], 2),
            'quality_grade' => $validated['quality_grade'],
            'market_name' => $validated['market_name'],
        ];

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('harvests', 'public');
        }

        $harvest->update($data);

        return redirect(route('admin.farms.show', $harvest->farm_id) . '?tab=harvest#harvest')
            ->with('success', 'Harvest details updated successfully.');
    }

    public function destroy(Harvest $harvest)
    {
        $farmId = $harvest->farm_id;
        $harvest->delete();
        return redirect(route('admin.farms.show', $farmId) . '?tab=harvest#harvest')
            ->with('success', 'Harvest record deleted successfully.');
    }
}
