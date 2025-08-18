<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Occasion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OccasionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $occasions = Occasion::orderBy('sort_order')->get();
        return view('admin.occasions.index', compact('occasions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.occasions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'alt_text' => 'required|string|max:255',
            'route' => 'required|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('occasions', 'public');
        }

        Occasion::create($validated);

        return redirect()->route('admin.occasions.index')
            ->with('success', 'Occasion created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Occasion  $occasion
     * @return \Illuminate\Http\Response
     */
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Occasion  $occasion
     * @return void
     */
    public function show(Occasion $occasion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Occasion $occasion)
    {
        return view('admin.occasions.edit', compact('occasion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Occasion $occasion)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'alt_text' => 'required|string|max:255',
            'route' => 'required|string|max:255',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0'
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($occasion->image) {
                Storage::disk('public')->delete($occasion->image);
            }
            $validated['image'] = $request->file('image')->store('occasions', 'public');
        }

        $occasion->update($validated);

        return redirect()->route('admin.occasions.index')
            ->with('success', 'Occasion updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Occasion $occasion)
    {
        if ($occasion->image) {
            Storage::disk('public')->delete($occasion->image);
        }
        
        $occasion->delete();

        return redirect()->route('admin.occasions.index')
            ->with('success', 'Occasion deleted successfully');
    }
}
