<?php

namespace App\Policies;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class UserPolicy
 *
 * @package App\Policies
 */
class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the given profile.
     *
     * @param User $user
     * @param User $signedInUser
     *
     * @return mixed
     */
    public function update(User $user, User $signedInUser)
    {
        return $signedInUser->id === $user->id;
    }
}
