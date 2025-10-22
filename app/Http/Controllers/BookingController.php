<?php

namespace App\Http\Controllers;

use App\Mail\Booking;
use App\Mail\Booking2;
use App\Models\Space;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class BookingController extends Controller
{
    
    public function create(Space $space)
    {
        return view('booking.create', ['space' => $space]);
    }

    public function store(Request $request, Space $space)
    {
        $validatedData = $request->validate([
            'duration' => 'required|max:50',
            'date_time' => 'required|after_or_equal:now',
           
       ]);

// Calculate total amount dynamically

$duration = $validatedData['duration'];
$date_time = $validatedData['date_time'];
    $amount = $space->rate * $duration * 100; // convert to pence/cents

    Stripe::setApiKey(env('STRIPE_SECRET'));

    $session = StripeSession::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price_data' => [
                'currency' => 'gbp',
                'product_data' => [
                    'name' => 'Booking for ' . $space->address,
                    'description' => "Duration: $duration hour(s) on $date_time",
                ],
                'unit_amount' => $amount,
            ],
            'quantity' => 1,
        ]],
        'mode' => 'payment',
        'success_url' => route('stripe.success', [
            'space_id' => $space->id,
            'duration' => $duration,
            'date_time' => $date_time,
        ]),
        'cancel_url' => route('stripe.cancel'),
    ]);


    return redirect($session->url);


    
    }
public function paymentSuccess(Request $request)
{
    $space = Space::find($request->space_id);

    if (!$space) {
        return redirect()->route('spaces.index')->with('error', 'Space not found');
    }

    // Create booking after payment success
    $booking = $space->bookings()->create([
        'user_id' => $request->user()->id,
        'duration' => $request->duration,
        'date_time' => $request->date_time,
        'amount' => $space->rate * $request->duration
    ]);

   //Send booking confirmation to user Uncomment to recieve mail notification - go to env file and input your gmail address and app password.
        $toEmail = $request->user()->email;
        $name_user = $request->user()->name;
        $duration = $request->duration;
        $date_time =  $request->date_time;
        $owner_email = $space->spaceOwner->user->email;
        $owner_phone = $space->spaceOwner->phone;
        $subject = "Booking confrimation";
        $address = $space->address;
        $postcode = $space->postcode;
        $amount = $space->rate * $request->duration;
        Mail::to($toEmail)->send(new Booking($duration, $date_time, $owner_email, $owner_phone, $address, $postcode, $subject, $name_user, $amount));


     //Send Booking confirmation to space owner
        $toEmailUser = $space->spaceOwner->user->email;
        $name_owner = $space->spaceOwner->user->name;
        $hours = $request->duration;
        $on = $request->date_time;
        $cus_email = $request->user()->email;
        $subject2 = "Booking Confirmation";
        $address2 = $space->address;
        $postcode2 = $space->postcode;
        $amount2 = $space->rate *  $request->duration;
        Mail::to($toEmailUser)->send(new Booking2($name_owner, $hours, $on, $cus_email, $subject2, $address2, $postcode2, $amount2));

    
    return redirect()->route('my-booking.index')->with('success', 'Payment successful and booking created!');
}

public function paymentCancel()
{
    return redirect()->back()->with('error', 'Payment was cancelled.');
}


   
}

