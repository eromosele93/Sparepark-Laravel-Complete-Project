<?php

namespace App\Http\Controllers;

use App\Models\Space;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SpaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $this->authorize('viewAny', Space::class);
        // $spaces = Space::query();
        // $spaces->when(request('search'), function ($query){
        //     $query->where(function($query){
        //         $query->where('address', 'like', '%'.request('search'). '%' )->orWhere
        //         ('city', 'like', '%'.request('search'). '%')->orWhere('postcode', 'like', '%'.request('search').'%');
        //     });
        // })->when(request('category'), function($query){
        //     $query->where('category', request('category'));
        // })->when(request('ev'), function($query){
        //     $query->where('ev', request('ev'));
        // });

        $this->authorize('viewAny', Space::class);

    $spaces = Space::query();

    // 🔹 Only search if postcode is provided
    if ($request->filled('search')) {
        $postcode = $request->get('search');

        // 1️⃣ Get coordinates of the postcode via Google Geocoding API
        $geoRes = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'address' => $postcode,
            'key' => env('GOOGLE_MAPS_API_KEY'),
        ]);

        if ($geoRes->successful() && $geoRes['status'] === 'OK') {
            $location = $geoRes['results'][0]['geometry']['location'];
            $lat = $location['lat'];
            $lng = $location['lng'];

            // 2️⃣ Find spaces within 10 km radius (adjust as you wish)
            $radius = 2; // km
            $haversine = "(6371 * acos(cos(radians($lat)) * cos(radians(latitude)) * cos(radians(longitude) - radians($lng)) + sin(radians($lat)) * sin(radians(latitude))))";

            $spaces->selectRaw("spaces.*, {$haversine} AS distance")
                   ->having('distance', '<=', $radius)
                   ->orderBy('distance', 'asc');
        } else {
            // If geocoding fails, return no results
            $spaces->whereRaw('1 = 0');
        }
    }

    // 🔹 Filter by category or EV (if selected)
    $spaces->when($request->filled('category'), fn($q) =>
        $q->where('category', $request->category)
    )->when($request->filled('ev'), fn($q) =>
        $q->where('ev', $request->ev)
    );

        return view('space.index', ['spaces' => $spaces->withAvg('reviews', 'rating')->withCount('reviews')->paginate(50)]);
    }

    
    public function show(string $id)
    {
       
        return view('space.show', ['space' => Space::with('reviews')->withAvg('reviews', 'rating')->withCount('reviews')
    ->findOrFail($id)]);
    }

   
    
}
