<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\RedirectResponse;

/**
 * Class FavoriteController
 *
 * @package App\Http\Controllers
 */
class FavoriteController extends Controller
{
    /**
     * FavoriteController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Reply $reply
     *
     * @return RedirectResponse
     */
    public function store(Reply $reply)
    {
        $reply->favorite();

        return back();
    }

    /**
     * @param Reply $reply
     */
    public function destroy(Reply $reply)
    {
        $reply->unfavorite();
    }
}
