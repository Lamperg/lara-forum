<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;

/**
 * Class ReplyController
 *
 * @package App\Http\Controllers
 */
class ReplyController extends Controller
{
    /**
     * ReplyController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param        $channel
     * @param Thread $thread
     *
     * @return RedirectResponse
     */
    public function store($channel, Thread $thread)
    {
        request()->validate([
            'body' => 'required',
        ]);

        $thread->addReply([
            'body' => request('body'),
            'user_id' => $this->getAuthUser()->id,
        ]);

        return back()
            ->with('flash', __('messages.reply.store'));
    }

    /**
     * @param Reply $reply
     *
     * @throws AuthorizationException
     */
    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->update([
            'body' => request('body'),
        ]);
    }

    /**
     * @param Reply $reply
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }

        return back();
    }
}
