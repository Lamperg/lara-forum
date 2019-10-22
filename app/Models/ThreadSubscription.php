<?php

namespace App\Models;

use App\Notifications\ThreadWasUpdated;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ThreadSubscription
 *
 * @property integer       $id
 * @property integer       $user_id
 * @property Carbon|string $created_at
 * @property Carbon|string $updated_at
 * @property User          $user
 * @property Thread        $thread
 *
 * @package App\Models
 * @mixin \Eloquent
 */
class ThreadSubscription extends Model
{
    /**
     * {@inheritDoc}
     */
    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    /**
     * @param Reply $reply
     */
    public function notify(Reply $reply)
    {
        $this->user->notify(new ThreadWasUpdated($this->thread, $reply));
    }
}
