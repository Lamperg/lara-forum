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
    protected $filters = ['by', 'popular', 'unanswered'];

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

    /**
     * Filters the query according to most popular threads.
     *
     * @return Builder
     */
    public function popular()
    {
        $this->builder->getQuery()->orders = [];

        return $this->builder->orderByDesc('replies_count');
    }

    /**
     * Filters the query according to the replies count.
     *
     * @return Builder
     */
    public function unanswered()
    {
        return $this->builder->where('replies_count', 0);
    }
}
