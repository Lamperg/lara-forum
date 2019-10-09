<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 *
 * @property integer               $id
 * @property string                $name
 * @property string                $email
 * @property string                $password
 * @property Carbon|string         $created_at
 * @property Carbon|string         $updated_at
 * @property Collection|Thread[]   $threads
 * @property Collection|Activity[] $activity
 *
 * @package App\Models
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'email',
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * {@inheritDoc}
     */
    public function getRouteKeyName()
    {
        return 'name';
    }

    /**
     * @return HasMany
     */
    public function threads()
    {
        return $this->hasMany(Thread::class)->latest();
    }

    /**
     * @return HasMany
     */
    public function activity()
    {
        return $this->hasMany(Activity::class);
    }
}
