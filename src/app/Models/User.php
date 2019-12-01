<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 *
 * @property integer                           $id
 * @property string                            $name
 * @property string                            $email
 * @property string                            $password
 * @property string                            $avatar_path
 * @property Reply                             $lastReply
 * @property Carbon|string                     $created_at
 * @property Carbon|string                     $updated_at
 * @property Collection|Thread[]               $threads
 * @property Collection|Activity[]             $activity
 * @property Collection|DatabaseNotification[] $notifications
 * @property Collection|DatabaseNotification[] $unreadNotifications
 *
 * @package App\Models
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;

    const AVATAR_STORAGE = '/storage/';
    const AVATAR_DEFAULT = 'img/avatars/default.jpg';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_path',
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

    /**
     * @return HasOne
     */
    public function lastReply()
    {
        return $this->hasOne(Reply::class)->latest();
    }

    /**
     * @param Thread $thread
     *
     * @throws \Exception
     */
    public function read(Thread $thread)
    {
        cache()->forever(
            $this->visitedThreadCacheKey($thread),
            Carbon::now()
        );
    }

    /**
     * @param $avatar
     *
     * @return string
     */
    public function getAvatarPathAttribute($avatar)
    {
        if (!$avatar) {
            return asset(self::AVATAR_DEFAULT);
        }

        return asset(self::AVATAR_STORAGE . $avatar);
    }

    /**
     * @param Thread $thread
     *
     * @return string
     */
    public function visitedThreadCacheKey(Thread $thread)
    {
        return sprintf("users.%s.visits.%s", $this->id, $thread->id);
    }
}
