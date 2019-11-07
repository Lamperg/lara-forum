<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create first user
        factory(User::class)->create([
            'name' => env('FIRST_USER_NAME'),
            'email' => env('FIRST_USER_EMAIL'),
            'password' => bcrypt(env('FIRST_USER_PASSWORD')),
        ]);

        // create second user
        factory(User::class)->create([
            'name' => env('SECOND_USER_NAME'),
            'email' => env('SECOND_USER_EMAIL'),
            'password' => bcrypt(env('FIRST_USER_PASSWORD')),
        ]);
    }
}
