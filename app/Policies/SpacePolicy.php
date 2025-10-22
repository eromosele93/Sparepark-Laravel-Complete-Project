<?php

namespace App\Policies;

use App\Models\Space;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SpacePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Space $space): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if($user->spaceOwner === null){
return false;
        }
        else{
            return true;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Space $space): bool|Response
    {
        if($space->spaceOwner->user_id === $user->id){
return true;
        }
else{
    return Response::deny('Cannot edit a space you didnt list');
}
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Space $space): bool|Response
    {
        if($space->spaceOwner->user_id === $user->id){
            return true;
                    }
            else{
                return Response::deny('Cannot delete a space you didnt list');
            }
    }
    public function show(User $user, Space $space): bool|Response
    {
        if($space->spaceOwner->user_id === $user->id){
            return true;
                    }
            else{
                return Response::deny('Cannot view a space you didnt list');
            }
    }

    /**
     * Determine whether the user can restore the model.
     */
   
}
