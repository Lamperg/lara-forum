<?php

use App\Models\User;
use App\Models\Thread;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/**
 * @var Factory $factory
 */
$factory->define(Thread::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(3),
        'body' => $faker->paragraph,
        'user_id' => factory(User::class),
    ];
});
