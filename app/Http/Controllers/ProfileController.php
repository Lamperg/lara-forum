<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Illuminate\Contracts\View\Factory;

/**
 * Class ProfileController
 *
 * @package App\Http\Controllers
 */
class ProfileController extends Controller
{
    /**
     * @param User $user
     *
     * @return Factory|View
     */
    public function show(User $user)
    {
        return view('profiles.show', [
            'profileUser' => $user,
            'activities' => $this->getActivity($user),
        ]);
    }

    /**
     * @param User $user
     *
     * @return Collection
     */
    protected function getActivity(User $user)
    {
        return $user->activity()
            ->latest()
            ->with('subject')
            ->take(50)
            ->get()
            ->groupBy(function (Activity $activity) {
                return $activity->created_at->format('Y-m-d');
            });
    }
}
