<?php

use Faker\Generator as Faker;
use App\Models\{Reply, Thread, User};
use Illuminate\Database\Eloquent\Factory;

/**
 * @var Factory $factory
 */
$factory->define(Reply::class, function (Faker $faker) {
    return [
        'body' => $faker->paragraph,
        'user_id' => \factory(User::class),
        'thread_id' => factory(Thread::class),
    ];
});
