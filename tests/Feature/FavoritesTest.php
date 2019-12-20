<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    /** @test */
    public function a_guest_can_not_like_a_reply()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->post('replies/1/favorites');
    }
    /** @test */
    public function a_auth_user_can_like_reply()
    {
        $reply = create('App\Reply');
        $this->singIn();
        $this->post('replies/' . $reply->id . '/favorites');
        $this->assertCount(1, $reply->favorites);
    }
    /** @test  */
    public function a_user_can_not_like_twice_this_same_post()
    {
        try {
            $reply = create('App\Reply');
            $this->singIn();
            $this->post('replies/' . $reply->id . '/favorites');
            $this->post('replies/' . $reply->id . '/favorites');
            $this->assertCount(1, $reply->favorites);
        } catch (\Exception $e) {
            $this->fail('Did not expect to insert the same record set twice');
        }
    }
}
