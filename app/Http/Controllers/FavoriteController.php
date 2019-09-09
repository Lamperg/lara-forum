<?php

namespace App\Http\Controllers;

use App\Models\Reply;
 use Illuminate\Database\Eloquent\Model;

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
     * @return Model
     */
    public function store(Reply $reply)
    {
        return $reply->favorite();
    }
}
