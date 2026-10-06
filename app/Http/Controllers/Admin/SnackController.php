<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Snack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SnackController extends Controller
{
    /**
     * Display all snacks.
     */
    public function index()
    {
        $snacks = Snack::latest()->get();

        return view('admin.snacks.index', compact('snacks'));
    }


    /**
     * Show create form.
     */
    public function create()
    {
        return view('admin.snacks.create');
    }


    /**
     * Store new snack.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'name' => 'required|string|max:255',

            'description' => 'nullable|string|max:1000',

            'price' => 'required|numeric|min:0',

            'category' => 'required|string|max:100',

            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

        ]);


        if ($request->hasFile('image')) {

            $validated['image'] =
                $request->file('image')->store('snacks', 'public');

        }


        $validated['is_available'] = true;


        Snack::create($validated);


        return redirect()
            ->route('admin.snacks.index')
            ->with('success', 'Snack added successfully.');
    }


    /**
     * Show edit form.
     */
    public function edit(Snack $snack)
    {
        return view('admin.snacks.edit', compact('snack'));
    }


    /**
     * Update snack.
     */
    public function update(Request $request, Snack $snack)
    {
        $validated = $request->validate([

            'name' => 'required|string|max:255',

            'description' => 'nullable|string|max:1000',

            'price' => 'required|numeric|min:0',

            'category' => 'required|string|max:100',

            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

        ]);


        if ($request->hasFile('image')) {

            if ($snack->image) {

                Storage::disk('public')->delete($snack->image);

            }


            $validated['image'] =
                $request->file('image')->store('snacks', 'public');
        }


        $snack->update($validated);


        return redirect()
            ->route('admin.snacks.index')
            ->with('success', 'Snack updated successfully.');
    }


    /**
     * Delete snack.
     */
    public function destroy(Snack $snack)
    {
        if ($snack->image) {

            Storage::disk('public')->delete($snack->image);

        }


        $snack->delete();


        return redirect()
            ->route('admin.snacks.index')
            ->with('success', 'Snack deleted successfully.');
    }


    /**
     * Enable / Disable snack.
     */
    public function toggleAvailability(Snack $snack)
    {
        $snack->update([
            'is_available' => !$snack->is_available,
        ]);


        return back()
            ->with('success', 'Snack availability updated.');
    }
}
