<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

/**
 * Class RegisterConfirmationController
 *
 * @package App\Http\Controllers\Api
 */
class RegisterConfirmationController extends Controller
{
    /**
     * @return RedirectResponse|Redirector
     */
    public function index()
    {
        /** @var User $user */
        $user = User::where('confirmation_token', request('token'))->first();

        if (!$user) {
            return redirect('threads')->with('flash', __('messages.user.unknown_token'));
        }

        $user->confirm();

        return redirect('threads')->with('flash', __('messages.user.email_confirmed'));
    }
}
