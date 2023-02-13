<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Package;
use App\Models\Product;
use App\Models\Sku;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skuPackage = Sku::factory()->create([
            'name' => 'Clothing Package'
        ]);
        $skuItems = Sku::inRandomOrder()->limit(2)->get();

        foreach ($skuItems as $skuItem) {
            Package::create([
                'package_id' => $skuPackage->id,
                'sku_id' => $skuItem->id,
                'quantity' => 2
            ]);
        }
    }
}
