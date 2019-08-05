<?php

namespace Tests\Unit;

use App\Models\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function hasPath()
    {
        /** @var Thread $thread */
        $thread = factory(Thread::class)->create();

        $this->assertEquals(route('threads.show', $thread), $thread->path());
    }
}
