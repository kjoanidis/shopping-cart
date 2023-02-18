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
        $package = Package::factory()->create([
            'name' => 'Clothing Package',
        ]);

        $skus = Sku::inRandomOrder()->limit(2)->get();

        foreach ($skus as $sku) {
            PackageSku::create([
                'package_id' => $package->id,
                'sku_id' => $sku->id,
                'quantity' => 2
            ]);
        }
    }
}
