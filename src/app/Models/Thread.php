<?php

namespace App\Models;

use App\Events\ThreadHasNewReply;
use App\Filters\Filters;
use App\Services\Visits;
use App\Traits\RecordsActivity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

/**
 * Class Thread
 *
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property string $body
 * @property Carbon|string $created_at
 * @property Carbon|string $updated_at
 * @property string $user_id
 * @property string $best_reply_id
 * @property Collection|Reply[] $replies
 * @property User $owner
 * @property Channel $channel
 * @property Collection|ThreadSubscription[] $subscriptions
 * @property integer $replies_count
 * @property bool $isSubscribedTo
 *
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
    protected $appends = ['isSubscribedTo'];

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
     * {@inheritDoc}
     */
    public function getRouteKeyName()
    {
        return 'slug';
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
        return "/threads/{$this->channel->slug}/{$this->slug}";
    }

    /**
     * @param $reply
     *
     * @return Model
     */
    public function addReply($reply)
    {
        $reply = $this->replies()->create($reply);

        event(new ThreadHasNewReply($this, $reply));

        return $reply;
    }

    /**
     * @param Reply $reply
     */
    public function markBestReply(Reply $reply)
    {
        $this->best_reply_id = $reply->id;
        $this->save();
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
     * @return $this
     */
    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?? auth()->id(),
        ]);

        return $this;
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

    /**
     * @return bool
     */
    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
            ->where('user_id', auth()->id())
            ->exists();
    }

    /**
     * @param User $user
     *
     * @return bool
     * @throws \Exception
     */
    public function hasUpdatesFor(User $user)
    {
        return $this->updated_at > cache($user->visitedThreadCacheKey($this));
    }

    /**
     * @return Visits
     */
    public function visits(): Visits
    {
        return new Visits($this);
    }

    /**
     * @param $value
     */
    public function setSlugAttribute($value)
    {
        $slug = Str::slug($value);

        if (static::where('slug', $slug)->exists()) {
            $slug = $this->incrementSlug($slug);
        }

        $this->attributes['slug'] = $slug;
    }

    public function incrementSlug($slug)
    {
        $max = static::where('title', $this->title)
            ->latest('id')
            ->value('slug');

        if (is_numeric($max[-1])) {
            preg_replace_callback('/(\d+)$/', function ($matches) {
                return $matches[1]++;
            }, $max);
        }

        return "$slug-2";
    }
}
