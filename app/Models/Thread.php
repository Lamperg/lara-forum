<?php

namespace App\Models;

use App\Traits\RecordsActivity;
use Carbon\Carbon;
use App\Filters\Filters;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Thread
 *
 * @property integer                         $id
 * @property string                          $title
 * @property string                          $body
 * @property Carbon|string                   $created_at
 * @property Carbon|string                   $updated_at
 * @property string                          $user_id
 * @property Collection|Reply[]              $replies
 * @property User                            $owner
 * @property Channel                         $channel
 * @property Collection|ThreadSubscription[] $subscriptions
 * @property integer                         $replies_count
 *
 * @method static Builder|Thread filter(Filters $filters)
 *
 * @package App\Models
 * @mixin \Eloquent
 */
class Thread extends Model
{
    use RecordsActivity;

    const STATE_CREATED = 'created_thread';

    /**
     * {@inheritDoc}
     */
    protected $guarded = [];

    /**
     * {@inheritDoc}
     */
    protected $with = ['owner', 'channel'];

    /**
     * {@inheritDoc}
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Thread $thread) {
            $thread->replies->each(function (Reply $reply) {
                $reply->delete();
            });
        });
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
     * @return BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * @return HasMany
     */
    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    /**
     * The path to the thread.
     *
     * @return string
     */
    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
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

    /**
     * @param Builder $query
     * @param Filters $filters
     *
     * @return Builder
     */
    public function scopeFilter(Builder $query, Filters $filters)
    {
        return $filters->apply($query);
    }

    /**
     * @param null $userId
     *
     * @return Model
     */
    public function subscribe($userId = null)
    {
        return $this->subscriptions()->create([
            'user_id' => $userId ?? auth()->id()
        ]);
    }

    /**
     * @param null $userId
     */
    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
            ->where('user_id', $userId ?? auth()->id())
            ->delete();
    }
}
