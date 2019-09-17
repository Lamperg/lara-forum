<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class Activity
 *
 * @property integer $id
 * @property User    $user
 * @property Model   $subject
 * @property string  $type
 *
 * @package App\Models
 * @mixin \Eloquent
 */
class Activity extends Model
{
    /**
     * {@inheritDoc}
     */
    protected $guarded = [];

    /**
     * @return MorphTo
     */
    public function subject()
    {
        return $this->morphTo();
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
