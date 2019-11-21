<?php

namespace App\Providers;

use App\Events\ThreadHasNewReply;
use App\Models\User;
use App\Notifications\YouWereMentioned;

class NotifyMentionedUsers
{
    /**
     * Handle the event.
     *
     * @param ThreadHasNewReply $event
     *
     * @return void
     */
    public function handle(ThreadHasNewReply $event)
    {
        preg_match_all('/\@([^\s\.]+)/', $event->reply->body, $matches);

        foreach ($matches[1] as $name) {
            $user = User::where('name', $name)->first();

            if ($user) {
                $user->notify(new YouWereMentioned($event->reply));
            }
        }
    }
}
