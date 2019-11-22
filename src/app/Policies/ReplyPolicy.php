<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the reply.
     *
     * @param User  $user
     * @param Reply $reply
     *
     * @return mixed
     */
    public function update(User $user, Reply $reply)
    {
        return $user->is($reply->owner);
    }

    /**
     * Determine whether the user can create the reply.
     *
     * @param User $user
     *
     * @return bool
     */
    public function create(User $user)
    {
        if (!$lastReply = $user->fresh()->lastReply) {
            return true;
        }

        return !$lastReply->wasJustPublished();
    }
}
