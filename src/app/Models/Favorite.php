<?php

namespace App\Models;

use App\Traits\RecordsActivity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * Class Favorite
 *
 * @property integer       $id
 * @property Carbon|string $created_at
 * @property Carbon|string $updated_at
 * @property Reply         $favorited
 *
 * @mixin \Eloquent
 * @package App\Models
 */
class Favorite extends Model
{
    use RecordsActivity;

    /**
     * {@inheritDoc}
     */
    protected $guarded = [];

    /**
     * @return MorphTo
     */
    public function favorited()
    {
        return $this->morphTo();
    }
}
