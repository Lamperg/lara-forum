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
        // create initial user
        factory(User::class)->create([
            'name' => env('INITIAL_USER_NAME'),
            'email' => env('INITIAL_USER_EMAIL'),
            'password' => bcrypt(env('INITIAL_USER_PASSWORD')),
        ]);
    }
}
