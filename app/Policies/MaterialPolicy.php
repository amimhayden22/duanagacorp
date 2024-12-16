<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Material;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class MaterialPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if(Auth::user()->can('Read Material'))
            return true;
        else
            return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Material $material): bool
    {
        if(Auth::user()->can('Read Material'))
            return true;
        else
            return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if(Auth::user()->can('Create Material'))
            return true;
        else
            return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Material $material): bool
    {
        if(Auth::user()->can('Update Material'))
            return true;
        else
            return false;
    }

    /**
     * Determine whether the user can delete the model.
    //  */
    // public function delete(User $user, Material $material): bool
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can restore the model.
    //  */
    // public function restore(User $user, Material $material): bool
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can permanently delete the model.
    //  */
    // public function forceDelete(User $user, Material $material): bool
    // {
    //     //
    // }
}
