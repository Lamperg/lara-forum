<?php

namespace App\Http\Controllers;

use App\Models\Thread;

/**
 * Class LockedThreadsController
 * @package App\Http\Controllers
 */
class LockedThreadsController extends Controller
{
    /**
     * LockedThreadsController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * @param Thread $thread
     */
    public function store(Thread $thread)
    {
        $thread->lock();
    }
}
