<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Order;
use Faker\Factory;
use Illuminate\Foundation\Testing\WithFaker;

class OrderTest extends TestCase
{

    use WithFaker;
   
    /**
     * A basic unit test example.
     *
     * @return void
     */

     public function test_can_create_order(){
         $data = [
            'orderCode' => $this->faker->unique()->numberBetween($min = 100, $max = 9000),
            'productId' => $this->faker->numberBetween($min = 1000, $max = 9000),
            'quantity' => $this->faker->randomDigitNot(0),
            'address' => $this->faker->sentences(10),
            'shippingDate' => $this->faker->dateTime($max = 'now', $timezone = null),
         ];
       
        $this->order(route('order.store'), $data)
            ->assertStatus(201)
            ->assertJson($data);
     }

     public function test_can_update_order()
    {
        $order = factory(order::class)->create();

        $data = [
            'orderCode' => $this->faker->unique()->numberBetween($min = 1000, $max = 9000),
            'productId' => $this->faker->numberBetween($min = 1000, $max = 9000),
            'quantity' => $this->faker->randomDigitNot(0),
            'address' => $this->faker->sentences(10),
            'shippingDate' => $this->faker->dateTime($max = 'now', $timezone = null),
         ];

        $this->put(route('order.update', $order->id), $data)
            ->assertStatus(200)
            ->assertJson($data);
    }

    public function test_can_show_order()
    {
        $order = factory(order::class)->create();

        $this->get(route('order.show', $order->id))
            ->assertStatus(200);
    }

    public function test_can_list_posts()
    {
        $order = factory(order::class, 2)->create()->map(function ($post) {
            return $order->only(['id', 'orderCode', 'productId','quantity','address','shippingDate']);
        });

        $this->get(route('order'))
            ->assertStatus(200)
            ->assertJson($order->toArray())
            ->assertJsonStructure([
                '*' => ['id', 'orderCode', 'productId','quantity','address','shippingDate']
            ]);
    }

}
