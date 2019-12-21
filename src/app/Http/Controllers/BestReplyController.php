<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Auth\Access\AuthorizationException;

/**
 * Class BestReplyController
 * @package App\Http\Controllers
 */
class BestReplyController extends Controller
{
    /**
     * @param Reply $reply
     * @throws AuthorizationException
     */
    public function store(Reply $reply)
    {
        $this->authorize('update', $reply->thread);

        $reply->thread->markBestReply($reply);
    }
}
