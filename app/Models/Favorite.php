<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Favorite
 *
 * @property integer       $id
 * @property Carbon|string $created_at
 * @property Carbon|string $updated_at
 *
 * @mixin \Eloquent
 * @package App\Models
 */
class Favorite extends Model
{
    /**
     * {@inheritDoc}
     */
    protected $guarded = [];
}
