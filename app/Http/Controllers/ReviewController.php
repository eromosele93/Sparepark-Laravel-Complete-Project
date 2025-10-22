<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Booking $booking)
    {
        

        $validatedData = $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'review' => 'required|max:255|min:5',
            
       ]);
        $booking->review()->create([
            'rating' => $validatedData['rating'],
            'review' => $validatedData['review'],
            'space_id' => $booking->space->id,
        ]);
        return redirect()->route('my-booking.index')->with('success', 'Booking reviewed successfull');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
