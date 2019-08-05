<?php

namespace App\Models;

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
 *
 * @package App\Models
 * @mixin \Eloquent
 */
class Reply extends Model
{
    /**
     * @return BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
