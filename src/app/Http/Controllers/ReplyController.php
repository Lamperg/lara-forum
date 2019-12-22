<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Inspections\Spam;
use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

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
        $this->middleware('auth', ['except' => 'index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Channel $channel
     * @param Thread $thread
     *
     * @return LengthAwarePaginator
     */
    public function index(Channel $channel, Thread $thread)
    {
        return $thread->replies()->paginate(Reply::PAGINATION_ITEMS);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param                                         $channel
     * @param Thread $thread
     *
     * @param CreatePostRequest $request
     *
     * @return ResponseFactory|Model|Response
     */
    public function store($channel, Thread $thread, CreatePostRequest $request)
    {
        if ($thread->locked) {
            return \response('Thread is locked', 422);
        }

        return $thread->addReply([
            'body' => $request->get('body'),
            'user_id' => $this->getAuthUser()->id,
        ])->load('owner');
    }

    /**
     * @param Reply $reply
     *
     * @param Spam $spam
     *
     * @return void
     * @throws AuthorizationException
     * @throws \Exception
     */
    public function update(Reply $reply, Spam $spam)
    {
        $this->authorize('update', $reply);

        $spam->detect(request('body'));

        $reply->update([
            'body' => request('body'),
        ]);
    }

    /**
     * @param Reply $reply
     *
     * @return ResponseFactory|RedirectResponse|Response
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
