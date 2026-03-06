<?php

namespace App\Http\Controllers;

use App\Models\Technology;
use App\Models\Rental;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $technologies = Technology::all();
        
        $totalAvailable = $technologies->sum('available_quantity');
        $totalPending = Rental::where('status', 'pending')->count();
        $totalFixing = Rental::where('status', 'fixing')->count();
        
        $rentals = Rental::with('technology')->orderBy('created_at', 'desc')->paginate(10);

        return view('rental.dashboard', compact(
            'technologies',
            'totalAvailable',
            'totalPending',
            'totalFixing',
            'rentals'
        ));
    }
}
