<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Inspections\Spam;
use App\Models\User;
use App\Notifications\YouWereMentioned;
use App\Rules\SpamFree;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

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
     * @param Thread  $thread
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
     * @param Thread                                  $thread
     *
     * @param CreatePostRequest                       $request
     *
     * @return Model
     */
    public function store($channel, Thread $thread, CreatePostRequest $request)
    {
        /** @var Reply $reply */
        $reply = $thread->addReply([
            'body' => $request->get('body'),
            'user_id' => $this->getAuthUser()->id,
        ]);

        preg_match_all('/\@([^\s\.]+)/', $reply->body, $matches);

        foreach ($matches[1] as $name) {
            $user = User::where('name', $name)->first();

            if ($user) {
                $user->notify(new YouWereMentioned($reply));
            }
        }

        return $reply->load('owner');
    }

    /**
     * @param Reply $reply
     *
     * @param Spam  $spam
     *
     * @return ResponseFactory|Response
     * @throws AuthorizationException
     * @throws \Exception
     */
    public function update(Reply $reply, Spam $spam)
    {
        $this->authorize('update', $reply);

        try {
            $spam->detect(request('body'));

            $reply->update([
                'body' => request('body'),
            ]);
        } catch (\Exception $e) {
            return response(__('messages.reply.store_error'), 422);
        }
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
