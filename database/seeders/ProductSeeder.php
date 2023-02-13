<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::insert([
            [
                'category_id' => Category::CLOTHING,
                'name' => 'T-Shirt'
            ],
            [
                'category_id' => Category::CLOTHING,
                'name' => 'Jumper'
            ],
            [
                'category_id' => Category::CLOTHING,
                'name' => 'Trousers'
            ],
        ]);
    }
}
