<?php

namespace App\Models;

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
 * @property integer            $id
 * @property string             $title
 * @property string             $body
 * @property Carbon|string      $created_at
 * @property Carbon|string      $updated_at
 * @property Collection|Reply[] $replies
 * @property User               $owner
 * @property Channel            $channel
 * @property int                $replies_count
 *
 * @method static Builder|Thread filter(Filters $filters)
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
     * {@inheritDoc}
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function (Builder $builder) {
            $builder->withCount('replies');
        });
    }

    /**
     * @return HasMany
     */
    public function replies()
    {
        return $this
            ->hasMany(Reply::class)
            ->withCount('favorites')
            ->with('owner');
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
}
