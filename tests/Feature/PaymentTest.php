<?php

namespace Tests\Feature;

use App\Enums\PaymentGatewaysEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;
use Faker\Factory as Faker;
use Illuminate\Support\Arr;

class PaymentTest extends TestCase
{
    protected $faker;

    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create(); // Initialize Faker instance
    }
    /**
     * A basic feature test example.
     */
    public function test_process_payment(): void
    {
        $user = User::factory()->create();
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
        $order_response = $this->withHeaders([
            'Authorization' => 'Bearer ' . JWTAuth::fromUser($user)
        ])->postJson('/api/v1/orders', $order_data);
        $payment_data = [
            'payment_method' => Arr::random(array_column(PaymentGatewaysEnum::cases(), 'value'))
        ];
        // Send a POST request to the API endpoint
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . JWTAuth::fromUser($user)
        ])->postJson('/api/v1/payments/store/' . $order_response->json()['data']['data']['id'], $payment_data);

        $response->assertStatus(200);
    }
}
