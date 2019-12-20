<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->thread = create('App\Thread');
    }

    /** @test */
    public function a_user_can_view_all_threads()
    {
        $response = $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    /** @test */
    public  function a_user_can_read_a_single_thread()
    {
        $response = $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }
    /** @test */
    public function a_user_can_replies_that_are_associated_with_a_thread()
    {
        $id = $this->thread->id;
        $reply = create('App\Reply', ['thread_id' => $id]);

        $this->get($this->thread->path())->assertSee($reply->body);
    }

    /** @test */
    public function is_reply_has_owner()
    {
        $reply = create('App\Reply');
        $this->assertInstanceOf('App\User', $reply->owner);
    }
    /** @test */
    public function is_thread_has_craetor()
    {
        $this->assertInstanceOf('App\User', $this->thread->creator);
    }
    /** @test */
    public function a_thread_has_replies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    /** @test */
    public function a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }
    /** @test */
    public function a_thread_belongs_to_a_channel()
    {
        $thread = create('App\Thread');
        $this->assertInstanceOf('App\Channel', $thread->channel);
    }

    /** @test*/
    public function a_thread_path_contains_channel()
    {
        $thread = create('App\Thread');
        $this->assertEquals('/threads/' . $thread->channel->slug . '/' . $thread->id, $thread->path());
    }

    /** @test */

    public function a_user_can_filter_threads_according_to_a_tag()
    {
        $channel = create('App\Channel');

        $threadToShow = create('App\Thread', ['channel_id' => $channel->id]);
        $threadToNotShow = create('App\Thread');
        $this->get('threads/' . $channel->slug)
            ->assertSee($threadToShow->title)
            ->assertDontSee($threadToNotShow->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_any_username()
    {
        $this->singIn(create('App\User', ['name' => 'TEST_Kacper']));

        $myThreads = create('App\Thread', ['user_id' => auth()->id()]);
        $theirThreads = create('App\Thread');

        $this->get('/threads?by=' . auth()->user()->name)
            ->assertSee($myThreads->title)
            ->assertDontSee($theirThreads->title);
    }
    /** @test */
    public function a_user_can_filter_by_popularity()
    {
        //
        $postWithThreeReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $postWithThreeReplies->id], 3);

        $postWithTwoReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $postWithTwoReplies->id], 2);


        $response = $this->getJson('threads?popularity=1')->json();
        $this->assertEquals([3, 2, 0], array_column($response, 'replies_count'));
        //$this->assertEquals(3,2,0);
    }
}
