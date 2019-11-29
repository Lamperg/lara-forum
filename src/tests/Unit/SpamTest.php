<?php

namespace Tests\Unit;

use App\Inspections\Spam;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class SpamTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var Spam
     */
    protected $spam;

    protected function setUp(): void
    {
        parent::setUp();

        $this->spam = App::make(Spam::class);
    }

    /**
     * @test
     */
    public function it_checks_for_invalid_keywords()
    {
        $this->assertFalse($this->spam->detect('Innocent reply here'));

        $this->expectException(\Exception::class);
        $this->spam->detect('yahoo customer support');
    }

    /**
     * @test
     */
    public function it_checks_for_any_key_being_held_down()
    {
        $this->expectException(\Exception::class);
        $this->spam->detect('Hello world aaaaaaaa');
    }
}
