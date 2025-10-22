<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class MyBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $my_bookings = auth()->user()->bookings()->latest()->withTrashed()->get();

        return view('my-bookings.index', ['bookings' => $my_bookings]);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $my_booking)
    {
        $this->authorize('create', $my_booking);
        $this->authorize('create2', $my_booking);
        return view('my-bookings.show', ['booking' => $my_booking]);
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
    public function destroy(Booking $my_booking)
    {
        $my_booking->delete();
        return redirect()->route('my-booking.index')->with('success', 'Booking cancelled!');
    }
}
