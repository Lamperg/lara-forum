<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

/**
 * Class UserNotificationsController
 *
 * @package App\Http\Controllers
 */
class UserNotificationsController extends Controller
{
    /**
     * UserNotificationsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return Collection|DatabaseNotification[]
     */
    public function index()
    {
        return $this->getAuthUser()->unreadNotifications;
    }

    /**
     * @param User $user
     * @param      $notificationId
     */
    public function destroy(User $user, $notificationId)
    {
        $this->getAuthUser()->notifications()->findOrFail($notificationId)->markAsRead();
    }
}
