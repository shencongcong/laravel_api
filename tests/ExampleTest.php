<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{

    /** @test */
    public function basic_example()
    {
        $this->visit('/')
        ->assertResponseOk();
    }
    

}
