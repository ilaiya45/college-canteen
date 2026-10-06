<?php

namespace App\Http\Controllers;

use App\Models\Snack;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
class AdminSnackController extends Controller
{
    public function index()
    {
        $snacks = Snack::latest()->get();

        return view('admin.snacks.index', compact('snacks'));
    }

    public function create()
    {
        return view('admin.snacks.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'category' => 'required|string|max:100',
        'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $imagePath = $request->file('image')->store('foods', 'public');

    Snack::create([
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
        'category' => $request->category,
        'image' => $imagePath,
        'is_available' => $request->has('is_available'),
    ]);

    return redirect()
        ->route('admin.snacks.index')
        ->with('success', 'Food item added successfully.');
}


    public function edit(Snack $snack)
    {
        return view('admin.snacks.edit', compact('snack'));
    }

    public function update(Request $request, Snack $snack)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Update Image
        |--------------------------------------------------------------------------
        */

        $imagePath = $snack->image;

        if ($request->hasFile('image')) {

            // Delete old image
            if ($snack->image && \Storage::disk('public')->exists($snack->image)) {
                \Storage::disk('public')->delete($snack->image);
            }

            // Store new image
            $imagePath = $request->file('image')
                ->store('foods', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Update Snack
        |--------------------------------------------------------------------------
        */

        $snack->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category' => $request->category,
            'image' => $imagePath,
            'is_available' => $request->has('is_available'),
        ]);

        return redirect()
            ->route('admin.snacks.index')
            ->with('success', 'Food item updated successfully.');
    }

    public function destroy(Snack $snack)
    {
        // Delete image from storage
        if ($snack->image && \Storage::disk('public')->exists($snack->image)) {
            \Storage::disk('public')->delete($snack->image);
        }

        $snack->delete();

        return redirect()
            ->route('admin.snacks.index')
            ->with('success', 'Food item deleted successfully.');
    }

    public function toggleAvailability(Snack $snack)
    {
        $snack->update([
            'is_available' => !$snack->is_available,
        ]);

        return redirect()
            ->route('admin.snacks.index')
            ->with('success', 'Food availability updated.');
    }
}
