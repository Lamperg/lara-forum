<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Thread
 *
 * @property integer $id
 * @property string  $title
 * @property string  $body
 *
 * @package App\Models
 * @mixin \Eloquent
 */
class Thread extends Model
{
    /**
     * @return string
     */
    public function path()
    {
        return route('threads.show', $this);
    }
}
