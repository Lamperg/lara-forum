<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Thread;

/**
 * Class ThreadSubscriptionsController
 *
 * @package App\Http\Controllers
 */
class ThreadSubscriptionsController extends Controller
{
    /**
     * ThreadSubscriptionsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Channel $channel
     * @param Thread  $thread
     */
    public function store(Channel $channel, Thread $thread)
    {
        $thread->subscribe();
    }

    /**
     * @param Channel $channel
     * @param Thread  $thread
     */
    public function destroy(Channel $channel, Thread $thread)
    {
        $thread->unsubscribe();
    }
}
