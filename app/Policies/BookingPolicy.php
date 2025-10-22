<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class BookingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Booking $booking): bool
    {
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Booking $booking): bool|Response
    {
        if($booking->user_id === $user->id){
return true;
        }else{
            return Response::deny('Cannot rate a booking you didnt make');  
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Booking $booking): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Booking $booking): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Booking $booking): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Booking $booking): bool
    {
       
    }
    public function create2(User $user, Booking $booking): bool|Response
    {
        if($booking->review){
            return Response::deny('You have already rated this booking');  
        }else{
            return true;
        }
    }
}
