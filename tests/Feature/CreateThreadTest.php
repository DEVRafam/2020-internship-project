<?php

namespace Tests\Feature;


use Tests\TestCase;

class CreateThreadTest extends TestCase
{
    /** @test  */
    public function a_auth_user_can_add_new_thread()
    {
        //stworzyc nowego usera
        $this->singIn();
        //stworzyc nowy watek
        $thread = make('App\Thread');
        //wyslac to
        $response = $this->post('threads', $thread->toArray());

        //wyswietlic i sprawdzic
        $this->get($response->headers->get('Location'))
            ->assertSee($thread->body);
    }
    /**  @test*/
    public function guests_may_not_create_threads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->post('threads', []);
    }
    /** @test */
    public function guest_can_not_see_thread_create_page()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->get('threads/create')->assertRedirect('login');
    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }
    /** @test */
    public function a_thread_requires_a_valid_channel_id()
    {
        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');
    }
    public function publishThread($data)
    {
        $this->singIn();
        $this->expectException('Illuminate\Validation\ValidationException');
        $thread = make('App\Thread', $data);
        return $this->post('/threads', $thread->toArray());
    }
}
