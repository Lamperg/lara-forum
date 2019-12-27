<?php

namespace Tests\Feature;

use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function user_can_search_threads()
    {
        config(['scout.driver' => 'algolia']);

        $search = 'foobar';

        create(Thread::class, [], 2);
        create(Thread::class, [
            "body" => "A thread with the {$search} term.",
        ], 2);

        do {
            sleep(.25);
            $results = $this->getJson("/threads/search?q={$search}")->json()['data'];
        } while (empty($results));

        $this->assertCount(2, $results);
        // clean up algolia from test threads
        Thread::latest()->take(4)->unsearchable();
    }
}
