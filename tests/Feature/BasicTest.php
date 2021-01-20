<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BasicTest extends TestCase
{
    /**
     * Test
     *
     * @return void
     */
    public function test_example()
    {
        $id = rand(0,100);
        $response = $this->get('/api/getTactic/' . $id);
        $response->assertStatus(200);
    }
}
