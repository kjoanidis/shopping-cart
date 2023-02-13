<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Package;
use App\Models\PackageSku;
use App\Models\Sku;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skuPackage = Package::factory()->create([
            'name' => 'Clothing Package',
        ]);

        Sku::factory()->create();

        $skuItems = Sku::inRandomOrder()->limit(2)->get();

        foreach ($skuItems as $skuItem) {
            PackageSku::create([
                'package_id' => $skuPackage->id,
                'sku_id' => $skuItem->id,
                'quantity' => 2
            ]);
        }
    }
}
