<?php

namespace App\Traits;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * Trait RecordsActivity
 *
 * @package App\Traits
 */
trait RecordsActivity
{
    /**
     * @return MorphMany
     */
    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    /**
     * The "booting" method of the trait
     */
    protected static function bootRecordsActivity()
    {
        if (auth()->guest()) {
            return;
        }

        foreach (static::getRecordableEvent() as $event) {
            static::$event(function (Model $model) use ($event) {
                $model->recordActivity($event);
            });
        }

        static::deleting(function (Model $model) {
            $model->activity()->delete();
        });
    }

    protected static function getRecordableEvent()
    {
        return ['created'];
    }

    /**
     * Records the model activity
     *
     * @param string $event
     */
    protected function recordActivity(string $event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),
        ]);
    }

    /**
     * @param string $event
     *
     * @return string
     */
    protected function getActivityType(string $event): string
    {
        return $event . '_' . strtolower(class_basename($this));
    }
}
