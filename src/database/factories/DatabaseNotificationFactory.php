<?php

use App\Models\User;
use App\Notifications\ThreadWasUpdated;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Notifications\DatabaseNotification;
use Ramsey\Uuid\Uuid;

/**
 * @var Factory $factory
 */
$factory->define(DatabaseNotification::class, function (Faker $faker) {
    return [
        'id' => Uuid::uuid4()->toString(),
        'type' => ThreadWasUpdated::class,
        'notifiable_id' => auth()->id() ?? factory(User::class),
        'notifiable_type' => User::class,
        'data' => ['foo' => 'bar']
    ];
});
