<?php

namespace App\Policies;

use App\Models\User;
use App\Models\facility_request;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Response as FacadesResponse;

class FacilityRequestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user,): bool
    {
        return $user->useRole == "Faculty Adviser" ||
            $user->useRole == "Organization Adviser" ||
            $user->useRole == "Heads" ||
            $user->useRole == "Deans" ||
            $user->useRole == "GSO Director" ||
            $user->userRole == "GSO Adviser";
    }


    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, facility_request $facilityRequest): bool
    {
        // return $user->userid == $facilityRequest->userid;
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, facility_request $facilityRequest): bool
    {

        return $user->userRole == "Faculty Adviser";
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, facility_request $facilityRequest): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, facility_request $facilityRequest): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, facility_request $facilityRequest): bool
    {
        return false;
    }
}
