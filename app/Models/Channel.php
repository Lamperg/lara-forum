<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Channel
 *
 * @property integer             $id
 * @property string              $name
 * @property string              $slug
 * @property Carbon|string       $created_at
 * @property Carbon|string       $updated_at
 * @property Collection|Thread[] $threads
 *
 * @package App\Models
 * @mixin \Eloquent
 */
class Channel extends Model
{
    /**
     * {@inheritDoc}
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * @return HasMany
     */
    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
}
