<?php

namespace App\Models;

use App\Traits\Favoritable;
use App\Traits\RecordsActivity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Stevebauman\Purify\Facades\Purify;

/**
 * Class Reply
 *
 * @property integer $id
 * @property string $body
 * @property Carbon|string $created_at
 * @property Carbon|string $updated_at
 * @property User $owner
 * @property Thread $thread
 *
 * @package App\Models
 * @mixin \Eloquent
 */
class Reply extends Model
{
    use Favoritable, RecordsActivity;

    const PAGINATION_ITEMS = 10;
    const STATE_CREATED = 'created_reply';

    /**
     * {@inheritDoc}
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function (Reply $reply) {
            $reply->thread->increment('replies_count');
        });

        static::deleted(function (Reply $reply) {
            $reply->thread->decrement('replies_count');
        });
    }

    /**
     * {@inheritDoc}
     */
    protected $guarded = [];

    /**
     * {@inheritDoc}
     */
    protected $with = ['owner', 'favorites'];

    /**
     * {@inheritDoc}
     */
    protected $appends = ['favoritesCount', 'isFavorited', 'isBest'];

    /**
     * @return BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsTo
     */
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    /**
     * @return string
     */
    public function path()
    {
        return $this->thread->path() . "#reply-{$this->id}";
    }

    /**
     * @return bool
     */
    public function wasJustPublished()
    {
        return $this->created_at->gt(Carbon::now()->subMinute());
    }

    /**
     * @return bool
     */
    public function isBest()
    {
        return $this->thread->best_reply_id == $this->id;
    }

    /**
     * @param $body
     */
    public function setBodyAttribute($body)
    {
        $this->attributes['body'] = preg_replace(
            '/@([\w\-]+)/',
            '<a href="/profiles/$1">$0</a>',
            $body
        );
    }

    /**
     * @return bool
     */
    public function getIsBestAttribute()
    {
        return $this->isBest();
    }

    /**
     * @param $body
     * @return mixed
     */
    public function getBodyAttribute($body)
    {
        return Purify::clean($body);
    }
}
