<?php

namespace App\Http\Controllers;

use App\Models\SpaceOwner;
use Illuminate\Http\Request;

class SpaceOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $space_owner = auth()->user()->spaceOwner;
        return view('space-owner.index', ['space_owner' => $space_owner]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       // $this->authorize('create', Employer::class);
       $this->authorize('create', SpaceOwner::class);
        return view('space-owner.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', SpaceOwner::class);
        $validatedData = $request->validate([
            'phone' => 'required',
       ]);
        $request->user()->spaceOwner()->create([
'phone' => $validatedData['phone'],
        ]);
return redirect()->route('my-space.index')->with('success', 'You have registered as a space owner!!!');

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
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SpaceOwner $space_owner)
    {
        $this->authorize('update', SpaceOwner::class);
        $validatedData = $request->validate([
            'phone' => 'required',
       ]);
        $request->user()->spaceOwner()->update([
'phone' => $validatedData['phone'],
        ]);
return redirect()->route('space-owner.index')->with('success', 'Phone number updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
