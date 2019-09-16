<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Channel;
use Illuminate\Http\Response;
use App\Filters\ThreadFilters;
use Illuminate\Database\Eloquent\Collection;

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
     * @param Channel       $channel
     * @param ThreadFilters $filters
     *
     * @return mixed
     */
    public function index(Channel $channel, ThreadFilters $filters)
    {
        /** @var Collection $threads */
        $threads = Thread::latest()->filter($filters)->get();

        if ($channel->exists) {
            $threads = $threads->where('channel_id', $channel->id);
        }
        if (\request()->wantsJson()) {
            return $threads;
        }

        return view('threads.index', compact('threads'));
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
     * @return void
     */
    public function store()
    {
        request()->validate([
            'body' => 'required',
            'title' => 'required',
            'channel_id' => 'required|exists:channels,id',
        ]);

        $thread = Thread::create([
            'body' => request('body'),
            'title' => request('title'),
            'user_id' => $this->getAuthUser()->id,
            'channel_id' => request('channel_id'),
        ]);

        return redirect($thread->path());
    }

    /**
     * Display the specified resource.
     *
     * @param        $channel
     * @param Thread $thread
     *
     * @return Response
     */
    public function show($channel, Thread $thread)
    {
        return view('threads.show', [
            'thread' => $thread,
            'replies' => $thread->replies()->paginate(20),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Channel $channel
     * @param Thread  $thread
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
