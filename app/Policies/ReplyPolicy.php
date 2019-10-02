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
}
