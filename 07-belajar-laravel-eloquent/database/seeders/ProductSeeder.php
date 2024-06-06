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
        for ($i = 0; $i < 10; $i++) {
            $product = new Product();
            $product->id = $i;
            $product->name = "Product $i";
            $product->description = "Product $i Description";
            $product->category_id = "FOOD";
            $product->save();
        }
    }
}
