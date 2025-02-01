<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function user_can_register(): void
    {
        $response = $this->postJson('/api/v1/register', [
            'name' => 'Test',
            'email' => 'test@test.com',
            'password' => '123456',
            'password-confirmation' => '123456',
            
        ]);

        $response->assertStatus(200);
    }
}
