<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\GeoCodeController;
use App\Http\Controllers\MyBookingController;
use App\Http\Controllers\MySpaceContrller;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SpaceController;
use App\Http\Controllers\SpaceOwnerController;
use App\Models\Space;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

Route::get('/', function () {
     $spaces = Space::get();
      Log::info('Spaces sent to home view:', $spaces->toArray());
    return view('home', ['spaces' =>$spaces]);
})->name('home');

Route::resource('spaces', SpaceController::class)->only(['index', 'show']);
Route::resource('register', RegisterController::class)->only(['create', 'store']);
Route::resource('auth', AuthController::class)->only(['create', 'store']);
Route::get('login', fn()=>to_route('auth.create'))->name('login');
Route::delete('auth', [AuthController::class, 'destroy'])->name('auth.destroy');
Route::middleware('auth')->group(function(){
    Route::middleware('space-owner')->resource('my-space', MySpaceContrller::class);
Route::resource('my-booking', MyBookingController::class )->only('index', 'show', 'destroy');
Route::resource('space-owner', SpaceOwnerController::class)->only(['create', 'store', 'index', 'update']);
Route::resource('space.booking', BookingController::class)->only(['create', 'store']);
Route::resource('booking.review', ReviewController::class)->only([ 'store']);

    });

Route::get('/geocode-proxy', function (Request $request) {
    $query = strtoupper(str_replace(' ', '', $request->get('address'))); // sanitize input

    Log::info('Autocomplete called with: ' . $query);

    if (!$query) {
        return response()->json(['addresses' => []]);
    }

    // Your working autocomplete API key
    $apiKey = '7MUZf37aukucNtIVHR_lxw48151';
    $url = "https://api.getAddress.io/autocomplete/{$query}?api-key={$apiKey}";

    try {
        $response = Http::get($url);

        Log::info('Autocomplete status: ' . $response->status());
        Log::info('Autocomplete body: ' . $response->body());

        if ($response->successful()) {
            $data = $response->json();

            // The autocomplete endpoint returns: { "suggestions": [ { "address": "...", "url": "..." } ] }
            $addresses = collect($data['suggestions'] ?? [])
                ->pluck('address')
                ->toArray();

            return response()->json(['addresses' => $addresses]);
        }

        return response()->json(['addresses' => []]);
    } catch (\Exception $e) {
        Log::error('Autocomplete error: ' . $e->getMessage());
        return response()->json(['addresses' => []]);
    }
});

Route::get('/payment-success', [BookingController::class, 'paymentSuccess'])->name('stripe.success');
Route::get('/payment-cancel', [BookingController::class, 'paymentCancel'])->name('stripe.cancel');

