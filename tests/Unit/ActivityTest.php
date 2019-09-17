<?php

namespace Tests\Unit;

use App\Models\Activity;
use App\Models\Reply;
use App\Models\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_records_activity_when_thread_is_created()
    {
        $this->signIn();
        /** @var Thread $thread */
        $thread = create(Thread::class);

        $this->assertDatabaseHas('activities', [
            'type' => Thread::STATE_CREATED,
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => get_class($thread),
        ]);

        /** @var Activity $activity */
        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    /**
     * @test
     */
    public function it_records_activity_when_reply_is_created()
    {
        $this->signIn();
        /** @var Reply $reply */
        $reply = create(Reply::class);

        $this->assertEquals(2, Activity::count());
    }
}
