<?php

namespace App\Filters;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ThreadFilters
 *
 * @package   App\Filters
 */
class ThreadFilters extends Filters
{
    /**
     * {@inheritDoc}
     */
    protected $filters = ['by'];

    /**
     * Filters the query by a given username.
     *
     * @param string $username
     *
     * @return Builder
     */
    protected function by(string $username)
    {
        /** @var User $user */
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }
}
