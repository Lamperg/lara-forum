<?php

namespace App\Http\Controllers;

use App\Filters\ThreadFilters;
use App\Models\Channel;
use App\Models\Thread;
use App\Rules\SpamFree;
use App\Services\Trending;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;

/**
 * Class ThreadController
 *
 * @package App\Http\Controllers
 */
class ThreadController extends Controller
{
    /**
     * ThreadController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Channel $channel
     * @param ThreadFilters $filters
     * @param Trending $trending
     * @return mixed
     */
    public function index(Channel $channel, ThreadFilters $filters, Trending $trending)
    {
        /** @var Collection $threads */
        $threads = Thread::latest()->filter($filters)->get();

        if ($channel->exists) {
            $threads = $threads->where('channel_id', $channel->id);
        }
        if (\request()->wantsJson()) {
            return $threads;
        }

        return view('threads.index', [
            'threads' => $threads,
            'trending' => $trending->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse|Redirector
     * @throws \Exception
     */
    public function store()
    {
        request()->validate([
            'channel_id' => 'required|exists:channels,id',
            'body' => ['required', resolve(SpamFree::class)],
            'title' => ['required', resolve(SpamFree::class)],
        ]);

        $thread = Thread::create([
            'body' => request('body'),
            'slug' => request('title'),
            'title' => request('title'),
            'user_id' => $this->getAuthUser()->id,
            'channel_id' => request('channel_id'),
        ]);

        return redirect($thread->path())
            ->with('flash', __('messages.thread.store'));
    }

    /**
     * Display the specified resource.
     *
     * @param        $channel
     * @param Thread $thread
     *
     * @param Trending $trending
     * @return Response
     */
    public function show($channel, Thread $thread, Trending $trending)
    {

        if ($user = auth()->user()) {
            $user->read($thread);
        }

        $trending->push($thread);
        $thread->visits()->record();

        return view('threads.show', compact('thread'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Channel $channel
     * @param Thread $thread
     *
     * @return mixed
     * @throws \Exception
     */
    public function destroy(Channel $channel, Thread $thread)
    {
        $this->authorize('update', $thread);

        $thread->delete();

        if (request()->wantsJson()) {
            return \response([], 204);
        }

        return redirect(route('threads.index'));
    }
}
