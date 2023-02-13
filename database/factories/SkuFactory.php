<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Customer>
 */
class SkuFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'product_id' => Product::inRandomOrder()->first()->id,
            'sku' => $this->generateRandomString(32),
            'price' => $this->faker->randomFloat(2, 20, 100)
        ];
    }

    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
