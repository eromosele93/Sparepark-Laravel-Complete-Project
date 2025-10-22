<?php

namespace App\Http\Controllers;

use App\Models\Space;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MySpaceContrller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $my_space = auth()->user()->spaceOwner->spaces()->latest()->withAvg('reviews', 'rating')->withCount('reviews')->withTrashed()->get();
        
        return view('my-spaces.index', ['spaces' =>$my_space]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Space::class);
        return view('my-spaces.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Space::class);
        $validatedData = $request->validate([
                     'address' => 'required',
                     'city' => 'required|max:255',
                     'postcode'=> 'required|max:255',
                     'rate' => 'required|numeric|min:1|max:48',
                     'ev' => 'required' ,
            'category' => 'required',
            'photo' => 'required',
          
                ]);
                $name = $request->file('photo')->getClientOriginalName();
                $request->file('photo')->storeAs('public/images', $name);

                auth()->user()->spaceOwner->spaces()->create(
                    [
                        'address' => $validatedData['address'],
                    'postcode' => $validatedData['postcode'],
                    'category' => $validatedData['category'],
                    'ev' => $validatedData['ev'],
                    'rate' => $validatedData['rate'],
                    'city' => $validatedData['city'],
                    'longitude' => $request->longitude,
                    'latitude' => $request->latitude,
                    'name' => $name,
                    ]
            
            );
 

                return redirect()->route('my-space.index')->with('success', 'Your employer account was created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Space $my_space)
    {
        $this->authorize('show', $my_space);
       return view('my-spaces.show', ['space' => $my_space]); 
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Space $my_space)
    {
        $this->authorize('update', $my_space);
        return view('my-spaces.edit', ['space' => $my_space]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Space $my_space)
    {
        $this->authorize('update', $my_space);
        $validatedData = $request->validate([
            'address' => 'required',
            'city' => 'required|max:255',
            'postcode'=> 'required|max:255',
            'rate' => 'required|numeric|min:1|max:48',
            'ev' => 'required' ,
   'category' => 'required',
       ]);
       

       auth()->user()->spaceOwner->spaces()->update(
           [
               'address' => $validatedData['address'],
           'postcode' => $validatedData['postcode'],
           'category' => $validatedData['category'],
           'ev' => $validatedData['ev'],
           'rate' => $validatedData['rate'],
           'city' => $validatedData['city'],
           
           ]
   
   );
       return redirect()->route('my-space.index')->with('success', 'Your employer account was created!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Space $my_space)
    {
        $this->authorize('delete', $my_space);
        $my_space->delete();
        return redirect()->route('my-space.index')->with('success', 'Space successfully deleted!');
    }
   
}
