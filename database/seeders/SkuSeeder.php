<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Product;
use App\Models\Sku;
use Illuminate\Database\Seeder;

class SkuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skuSizeNames = [];
        foreach (Product::all() as $product) {
            foreach (Attribute::SIZES as $size) {
                $skuSizeNames[] = [
                    'product_id' => $product->id,
                    'name' => "{$product->name} {$size}",
                    'size_name' => $size
                ];
            }
        }

        $skuNames = [];
        foreach ($skuSizeNames as $skuSizeName) {
            foreach (Attribute::COLOURS as $colour) {
                $skuNames[] = [
                    'product_id' => $skuSizeName['product_id'],
                    'name' => "{$skuSizeName['name']} {$colour}",
                    'size_name' => $skuSizeName['size_name'],
                    'colour' => $colour
                ];
            }
        }

        foreach ($skuNames as $skuName) {
            $sku = Sku::factory()->create([
                'product_id' => $skuName['product_id'],
                'name' => $skuName['name']
            ]);

            Attribute::where('product_id', $skuName['product_id'])
                ->colour()
                ->first()
                ->skus()
                ->attach($sku->id, ['value' => $skuName['colour']]);

            Attribute::where('product_id', $skuName['product_id'])
                ->size()
                ->first()
                ->skus()
                ->attach($sku->id, ['value' => $skuName['size_name']]);
        }
    }
}
