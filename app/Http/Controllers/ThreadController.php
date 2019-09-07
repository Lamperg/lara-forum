<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Thread;
use App\Models\Channel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
     *
     * @return Response
     */
    public function index(Channel $channel)
    {
        if ($channel->exists) {
            $threads = $channel->threads()->latest();
        } else {
            $threads = Thread::latest();
        }

        // if request 'by' we should filter by the given username
        if ($username = \request('by')) {
            /** @var User $user */
           $user = User::where('name', $username)->firstOrFail();
           $threads->where('user_id', $user->id);
        }

        $threads = $threads->get();

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
        return view('threads.show', compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Thread $thread
     *
     * @return Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Thread  $thread
     *
     * @return Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Thread $thread
     *
     * @return Response
     */
    public function destroy(Thread $thread)
    {
        //
    }
}
