<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

/**
 * Class UserAvatarController
 *
 * @package App\Http\Controllers\Api
 */
class UserAvatarController extends Controller
{
    /**
     * UserAvatarController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return RedirectResponse
     */
    public function store()
    {
        request()->validate([
            'avatar' => ['required', 'image'],
        ]);

        $this->getAuthUser()->update([
            'avatar_path' => \request()->file('avatar')->store('avatars', 'public'),
        ]);

        return back();
    }
}
