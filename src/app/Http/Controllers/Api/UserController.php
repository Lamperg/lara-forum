<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

/**
 * Class UserController
 *
 * @package App\Http\Controllers\Api
 */
class UserController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        $search = \request('name');

        return User::where('name', 'LIKE', "$search%")
            ->take(5)
            ->pluck('name');
    }
}
