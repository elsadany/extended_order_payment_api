<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Faker\Factory as Faker;
use Tymon\JWTAuth\Facades\JWTAuth;

class OrdersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    protected $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create(); // Initialize Faker instance
    }

    public function test_create_order(): void
    {
        $order_data = [
            'user_name' => $this->faker->name,
            'user_email' => $this->faker->unique()->safeEmail,
            'items' => [
                [
                    'product_name' => $this->faker->word,
                    'quantity' => $this->faker->numberBetween(1, 10),
                    'price' => $this->faker->randomFloat(2, 10, 1000),
                ],
                [
                    'product_name' => $this->faker->word,
                    'quantity' => $this->faker->numberBetween(1, 10),
                    'price' => $this->faker->randomFloat(2, 10, 1000),
                ],
            ],
        ];
        $user = User::factory()->create();
        // Send a POST request to the API endpoint
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . JWTAuth::fromUser($user)
        ])->postJson('/api/v1/orders', $order_data);

        $response->assertStatus(200);
    }
}
