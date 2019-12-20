<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

/**
 * Class RegisterConfirmationController
 *
 * @package App\Http\Controllers\Api
 */
class RegisterConfirmationController extends Controller
{
    public function index()
    {
        User::where('confirmation_token', request('token'))
            ->firstOrFail()
            ->confirm();
    }
}
