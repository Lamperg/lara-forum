<?php

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Collection;

class ThreadsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var Collection $projects */
        $threads = factory(Thread::class, 10)->create();

        // create replies for each project
        $threads->each(function (Thread $thread) {
            $replies = factory(Reply::class, 5)->make([
                'thread_id' => $thread->id,
            ]);

            $thread->replies()->saveMany($replies);
        });
    }
}
