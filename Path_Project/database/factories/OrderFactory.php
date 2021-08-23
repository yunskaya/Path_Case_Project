<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'orderCode' => $this->faker->unique()->numberBetween($min = 1000, $max = 9000),
            'productId' => $this->faker->numberBetween($min = 1000, $max = 9000),
            'quantity' => $this->faker->randomDigitNot(0),
            'address' => $this->faker->sentences(10),
            'shippingDate' => $this->faker->dateTime($max = 'now', $timezone = null),
        ];
    }
}
