<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChannelTest extends TestCase
{
    /**
     * @test
     */
    public function a_channel_contains_threads()
    {
        $channnel = create('App\Channel');
        $thread = create('App\Thread', ['channel_id' => $channnel->id]);

        $this->assertTrue($channnel->threads->contains($thread));
    }
}
