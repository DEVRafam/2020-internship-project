<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations as TestingDatabaseMigrations;


abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use TestingDatabaseMigrations;
    protected function singIn($user = null)
    {
        $user = $user ?: create('App\User');
        $this->actingAs($user);

        return $this;
    }
}
