<?php

namespace App\Models;

use App\Traits\Favoritable;
use App\Traits\RecordsActivity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Reply
 *
 * @property integer       $id
 * @property string        $body
 * @property Carbon|string $created_at
 * @property Carbon|string $updated_at
 * @property User          $owner
 * @property Thread        $thread
 *
 * @package App\Models
 * @mixin \Eloquent
 */
class Reply extends Model
{
    use Favoritable, RecordsActivity;

    const STATE_CREATED = 'created_reply';

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
    protected $appends = ['favoritesCount', 'isFavorited'];

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
}
