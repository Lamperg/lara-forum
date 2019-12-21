<?php

use App\Models\User;
use App\Models\Thread;
use App\Models\Channel;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/**
 * @var Factory $factory
 */
$factory->define(Thread::class, function (Faker $faker) {
    $title = $faker->sentence;

    return [
        'title' => $title,
        'body' => $faker->paragraph,
        'user_id' => factory(User::class),
        'channel_id' => factory(Channel::class),
        'slug' => \Str::slug($title)
    ];
});
