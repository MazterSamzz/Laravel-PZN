<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ImageSeeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertNotNull;

class ProductTest extends TestCase
{
    public function testOneToMany(): void
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $product = Product::find('1');
        self::assertNotNull($product);

        $category = $product->category;
        self::assertNotNull($category);
        self::assertEquals('FOOD', $category->id);
    }

    public function testhasOneOfMany(): void
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $category = Category::find('FOOD');

        $cheapestProduct = $category->cheapestProduct;
        self::assertNotNull($cheapestProduct);
        self::assertEquals(0, $cheapestProduct->id);

        $mostExpensiveProduct = $category->mostExpensiveProduct;
        self::assertNotNull($mostExpensiveProduct);
        self::assertEquals(9, $mostExpensiveProduct->id);
    }

    public function testOneToOnePolyMOrphic(): void
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class, ImageSeeder::class]);

        $product = Product::find('1');
        self::assertNotNull($product);

        $image = $product->image;
        self::assertNotNull($image);
        self::assertEquals('https://www.programmerzamannow.com/image/2.jpg', $image->url);
    }
}
