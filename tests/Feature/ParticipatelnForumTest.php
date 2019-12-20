<?php

namespace Tests\Feature;

use Tests\TestCase;

class ParticipatelnForum extends TestCase
{


    /** @test */
    public function unauth_user_may_not_add_repiles()
    {
        //sprawdzanie dyntki z autoryzacja
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->post('/threads/1/replies', []);
    }
    /** @test */
    public function a_auth_user_may_participate_in_forum_threads()
    {
        //tutaj tworzymy sobie fejkowe rekordy, na ktorych bedziemy operowac
        //$this->be() symuluje zalogowanego usera, uzycie $user= factory('App\User')->create(); 
        //wywali blad

        $this->be($user = create('App\User'));
        $thread = create('App\Thread');

        //to nie tworzy rekordu,tylko dane potrzebne do jego stworzenia
        $reply = make('App\Reply');
        //postujemy dane do kontrolera
        $this->post($thread->path() . '/replies', $reply->toArray());

        //probujemy otworzyc nowo stworzony watek i znalezc w nim odpowiedz
        $this->get($thread->path())
            ->assertSee($reply->body);
    }
    /** @test */
    public function a_reply_requires_a_body()
    {
        $this->expectException('Illuminate\Validation\ValidationException');
        $this->singIn();
        $reply = make('App\Reply', ['body' => null]);
        $thread = create('App\Thread');

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertSessionHasErrors('body');
    }
}
