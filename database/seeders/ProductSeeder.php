<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->products() as $key => $product) {
            Product::firstOrCreate([
                "name" => $product->name,
                "brand" => $product->brand
            ]);
        }
    }

    private function products()
    {
        return [
            (object)[
                "name" => "iPhone X",
                "brand" => "Apple",
            ],
            (object)[
                "name" => "Wine",
                "brand" => "wineDepot"
            ],
            (object)[
                "name" => "EyeGlass",
                "brand" => "EO"
            ],
            (object)[
                "name" => "Mac",
                "brand" => "Apple"
            ],
            (object)[
                "name" => "Mac Mini",
                "brand" => "Apple"
            ],
        ];
    }
}
