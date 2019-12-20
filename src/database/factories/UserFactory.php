<?php

use App\Models\User;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/**
 * @var Factory $factory
 */
$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'confirmed' => true,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->state(User::class, 'unconfirmed', function () {
    return [
        'confirmed' => false,
    ];
});
