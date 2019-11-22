<?php

namespace Tests\Unit;

use App\Models\Activity;
use App\Models\Reply;
use App\Models\Thread;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
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

    /**
     * @test
     */
    public function it_fetches_a_feed_for_any_user()
    {
        $user = $this->signIn();

        create(Thread::class, ['user_id' => $user->id,], 2);

        $user->activity()->first()->update([
            'created_at' => Carbon::now()->subWeek(),
        ]);

        $feed = Activity::feed($user);

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));
        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('Y-m-d')
        ));
    }
}
