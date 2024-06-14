<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CommentSeeder;
use Database\Seeders\ImageSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\TagSeeder;
use Database\Seeders\VoucherSeeder;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
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

    public function testOneToManyPolymorphic(): void
    {
        $this->seed([
            CategorySeeder::class, ProductSeeder::class, VoucherSeeder::class, CommentSeeder::class
        ]);

        $product = Product::find('1');
        self::assertNotNull($product);

        $comments = $product->comments;
        self::assertNotNull($comments);

        foreach ($comments as $comment) {
            self::assertEquals('Product Title 1', $comment->title);
            self::assertEquals('MazterSamzz@product1.com', $comment->email);
            self::assertEquals('product', $comment->commentable_type);
            self::assertEquals($product->id, $comment->commentable_id);
        }

        $product = Product::find('2');
        self::assertNotNull($product);

        $comments = $product->comments;
        self::assertNotNull($comments);

        foreach ($comments as $comment) {
            self::assertEquals('Product Title 2', $comment->title);
            self::assertEquals('MazterSamzz@product2.com', $comment->email);
            self::assertEquals('product', $comment->commentable_type);
            self::assertEquals($product->id, $comment->commentable_id);
        }
    }

    public function testOneOfManyPolymorphic(): void
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class, VoucherSeeder::class, CommentSeeder::class]);

        $product = Product::find('1');
        self::assertNotNull($product);

        $comment = $product->latestComment;
        self::assertNotNull($comment);

        $comment = $product->oldestComment;
        self::assertNotNull($comment);
    }

    public function testmanyToManyPolymorph(): void
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class, VoucherSeeder::class, TagSeeder::class]);

        $product = Product::find('1');
        self::assertNotNull($product);

        $tags = $product->tags;
        self::assertNotNull($tags);

        foreach ($tags as $tag) {
            self::assertNotNull($tag->id);
            self::assertNotNull($tag->name);

            $vouchers = $tag->vouchers;
            self::assertNotNull($vouchers);
            self::assertCount(1, $vouchers);
        }
    }

    public function testEloquentCollection()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        // 10 product 0- 9
        $products = Product::get();

        // WHERE id IN (1, 2, ... ,9)
        $products = $products->toQuery()->where('price', 5000)->get();
        self::assertNotNull($products);
        self::assertEquals("4", $products[0]->id);
    }

    public function testSerialization()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $products = Product::get();
        self::assertCount(10, $products);

        $json = $products->toJson(JSON_PRETTY_PRINT);
        Log::info($json);
    }

    public function testSerializationRelation()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class, ImageSeeder::class]);

        $products = Product::get();
        self::assertCount(10, $products);

        $products->load(['category', 'image']);

        $json = $products->toJson(JSON_PRETTY_PRINT);
        Log::info($json);
    }
}
