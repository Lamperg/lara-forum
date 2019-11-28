<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class UserAvatarController extends Controller
{
    /**
     * UserAvatarController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(User $user)
    {
        request()->validate([
            'avatar' => ['required', 'image'],
        ]);

        $user->update([
            'avatar_path' => \request()->file('avatar')->storeAs('avatars', 'avatar.jpg', 'public'),
        ]);
    }
}
