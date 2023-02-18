<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            [
                'id' => Category::CLOTHING,
                'name' => 'Clothing',
                'description' => ''
            ],
            [
                'id' => Category::HEALTH_AND_BEAUTY,
                'name' => 'Health & Beauty',
                'description' => ''
            ],
            [
                'id' => Category::SUBSCRIPTIONS,
                'name' => 'Subscriptions',
                'description' => ''
            ]
        ]);

    }
}
