<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @param null $user
     *
     * @return User
     */
    public function signIn($user = null): User
    {
        $user = $user ?? create(User::class);

        $this->actingAs($user);

        return $user;
    }
}
