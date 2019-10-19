<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ThreadSubscription
 *
 * @property integer       $id
 * @property Carbon|string $created_at
 * @property Carbon|string $updated_at
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
}
