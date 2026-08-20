<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Farm;
use App\Models\FarmUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FarmUpdateController extends Controller
{
    public function store(Request $request, Farm $farm)
    {
        $user = Auth::user();
        if (!$user->is_admin && (!$user->farmer || ($farm->farmer_id && $farm->farmer_id !== $user->farmer->id))) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:5120',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $imagePath = $file->storeAs('farm_updates', $fileName, 'public');
        }

        FarmUpdate::create([
            'farm_id' => $farm->id,
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Live update posted successfully!');
    }
}
