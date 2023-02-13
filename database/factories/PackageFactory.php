<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Sku;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Customer>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $parent = Sku::factory()->create();
        $child = Sku::factory()->create();

        return [
            'package_id' => $parent->id,
            'sku_id' => $child->id,
            'quantity' => fake()->numberBetween(1, 10)
        ];
    }
}
