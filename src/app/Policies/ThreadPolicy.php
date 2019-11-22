<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Thread;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class ThreadPolicy
 *
 * @package App\Policies
 */
class ThreadPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the thread.
     *
     * @param User   $user
     * @param Thread $thread
     *
     * @return mixed
     */
    public function update(User $user, Thread $thread)
    {
        return $user->is($thread->owner);
    }
}
