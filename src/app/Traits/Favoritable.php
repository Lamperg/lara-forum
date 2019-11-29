<?php

namespace App\Traits;

use App\Models\Favorite;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Trait Favoritable
 *
 * @property Collection|Favorite[] $favorites
 *
 * @package App\Traits
 */
trait Favoritable
{
    /**
     * The "booting" method of the trait
     */
    protected static function bootFavoritable()
    {
        static::deleting(function (Model $model) {
            $model->favorites->each->delete();
        });
    }

    /**
     * @return MorphMany
     */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    /**
     * Favorites a reply by authenticated user.
     *
     * @return Model
     */
    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];
        if (!$this->favorites()->where($attributes)->exists()) {
            return $this->favorites()->create($attributes);
        }
    }

    /**
     * Unfavorites a reply by authenticated user.
     */
    public function unfavorite()
    {
        $favorites = $this->favorites()->where([
            'user_id' => auth()->id(),
        ])->get();

        $favorites->each(function (Favorite $favorite) {
            $favorite->delete();
        });
    }

    /**
     * @return bool
     */
    public function isFavorited()
    {
        return $this->favorites->where('user_id', auth()->id())->count();
    }

    /**
     * @return int
     */
    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    /**
     * @return bool
     */
    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }
}
