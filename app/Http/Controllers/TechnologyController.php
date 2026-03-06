<?php

namespace App\Http\Controllers;

use App\Models\Technology;
use App\Models\Rental;
use Illuminate\Http\Request;

class TechnologyController extends Controller
{
    public function index()
    {
        $technologies = Technology::all();
        return view('rental.technologies.index', compact('technologies'));
    }

    public function create()
    {
        return view('rental.technologies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_path' => 'nullable|string',
            'total_quantity' => 'required|integer|min:1',
        ]);

        $validated['available_quantity'] = $validated['total_quantity'];
        $validated['status'] = 'available';

        Technology::create($validated);

        return redirect()->route('rental.dashboard')->with('success', 'Technology added successfully');
    }

    public function edit(Technology $technology)
    {
        return view('rental.technologies.edit', compact('technology'));
    }

    public function update(Request $request, Technology $technology)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_path' => 'nullable|string',
            'total_quantity' => 'required|integer|min:1',
            'status' => 'required|in:available,fixing',
        ]);

        $technology->update($validated);

        return redirect()->route('rental.dashboard')->with('success', 'Technology updated successfully');
    }

    public function destroy(Technology $technology)
    {
        $technology->delete();
        return redirect()->route('rental.dashboard')->with('success', 'Technology deleted successfully');
    }
}
