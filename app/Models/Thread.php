<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Thread
 *
 * @property integer            $id
 * @property string             $title
 * @property string             $body
 * @property Carbon|string      $created_at
 * @property Carbon|string      $updated_at
 * @property Collection|Reply[] $replies
 * @property User               $owner
 *
 * @package App\Models
 * @mixin \Eloquent
 */
class Thread extends Model
{
    /**
     * {@inheritDoc}
     */
    protected $guarded = [];

    /**
     * The path to the thread.
     *
     * @return string
     */
    public function path()
    {
        return route('threads.show', $this);
    }

    /**
     * @return HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * @return BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @param $reply
     *
     * @return Model
     */
    public function addReply($reply)
    {
        return $this->replies()->create($reply);
    }
}
