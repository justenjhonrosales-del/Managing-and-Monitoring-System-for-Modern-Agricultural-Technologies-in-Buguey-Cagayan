<?php

namespace App\Http\Controllers;

use App\Models\Technology;
use App\Models\Rental;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function create()
    {
        $technologies = Technology::all();
        return view('rental.rentals.create', compact('technologies'));
    }

    public function storeRental(Request $request)
    {
        $validated = $request->validate([
            'renter_name' => 'required|string|max:255',
            'renter_phone' => 'required|string|max:20',
            'renter_address' => 'required|string|max:255',
            'technology_id' => 'required|exists:technologies,id',
            'rental_hours' => 'required|integer|min:1',
            'rental_days' => 'required|integer|min:0',
            'payment_amount' => 'required|numeric|min:0',
            'fully_paid' => 'nullable|boolean',
            'renter_email' => 'required|email',
            'rental_date' => 'required|date',
        ]);

        $validated['status'] = 'pending';
        $validated['fully_paid'] = $request->has('fully_paid');
        
        Rental::create($validated);

        return redirect()->route('rental.dashboard')->with('success', 'Rental request created successfully');
    }

    public function updateStatus(Request $request, Rental $rental)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,fixing,returned',
        ]);

        $rental->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', 'Rental status updated successfully');
    }

    public function addLog(Request $request, Rental $rental)
    {
        $validated = $request->validate([
            'notes' => 'nullable|string',
        ]);

        $rental->update(['notes' => $validated['notes']]);

        return redirect()->back()->with('success', 'Log updated successfully');
    }
}

