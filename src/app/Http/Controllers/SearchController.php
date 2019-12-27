<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Services\Trending;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

/**
 * Class SearchController
 *
 * @package App\Http\Controllers
 */
class SearchController extends Controller
{
    /**
     * @param Trending $trending
     *
     * @return LengthAwarePaginator|Factory|View
     */
    public function show(Trending $trending)
    {
        $search = request('q');

        $threads = Thread::search($search)->paginate(25);

        if (request()->expectsJson()) {
            return $threads;
        }

        return view('threads.index', [
            'threads' => $threads,
            'trending' => $trending->get(),
        ]);
    }
}
