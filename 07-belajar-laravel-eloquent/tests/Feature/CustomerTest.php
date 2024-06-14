<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Wallet;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ImageSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\VirtualAccountSeeder;
use Database\Seeders\WalletSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    public function testOneToOne(): void
    {
        $this->seed([CustomerSeeder::class, WalletSeeder::class]);

        $customer = Customer::find('IVAN');

        $this->assertNotNull($customer);
        $this->assertEquals(1000000, $customer->wallet->amount);
    }

    public function testOneToOneQuery(): void
    {
        $customer = new Customer();
        $customer->id = 'IVAN';
        $customer->name = 'Ivan';
        $customer->email = 'MazterSamzz@gmail.com';
        $customer->save();

        $wallet = new Wallet();
        $wallet->amount = 1000000;

        $customer->wallet()->save($wallet);

        Self::assertNotNull($wallet->customer_id);
    }

    public function testOneToManyQuery(): void
    {
        $category = new Category();

        $category->id = 'FOOD';
        $category->name = 'Food';
        $category->description = 'Food Category';
        $category->is_active = true;
        $category->save();

        $product = new Product();
        $product->id = '1';
        $product->name = 'Product 1';
        $product->description = 'Description 1';
        $category->products()->save($product);

        self::assertNotNull($product->category_id);
    }

    public function testHasOneThrough(): void
    {
        $this->seed([CustomerSeeder::class, WalletSeeder::class, VirtualAccountSeeder::class]);

        $customer = Customer::find('IVAN');
        self::assertNotNull($customer);

        $virtualAccount = $customer->virtualAccount;
        self::assertNotNull($virtualAccount);
        self::assertEquals('BCA', $virtualAccount->bank);
        self::assertEquals('1231234432', $virtualAccount->va_number);
    }

    public function testManyToMany(): void
    {
        $this->seed([CustomerSeeder::class, CategorySeeder::class, ProductSeeder::class]);

        $customer = Customer::find('IVAN');
        self::assertNotNull($customer);

        $customer->likeProducts()->attach('1'); // ID product = 1
        $customer->likeProducts()->attach('2'); // ID product = 2

        $products = $customer->likeProducts;
        self::assertCount(2, $products);

        self::assertEquals(1, $products[0]->id);
        self::assertEquals(2, $products[1]->id);
    }

    public function testManyToManyDetach(): void
    {
        $this->testManyToMany();
        $customer = Customer::find('IVAN');
        // DB::table('customers_likes_products')->where('customer_id', $customer->id)->where('product_id', '1')->delete();
        $customer->likeProducts()->detach('1');

        $products = $customer->likeProducts;
        self::assertCount(1, $products);
    }

    public function testPivotAttribut(): void
    {
        $this->testManyToMany();
        $customer = Customer::find('IVAN');
        $products = $customer->likeProducts;

        foreach ($products as $product) {
            $pivot = $product->pivot;
            self::assertNotNull($pivot->customer_id);
            self::assertNotNull($pivot->product_id);
            self::assertNotNull($pivot->created_at);
        }
    }

    public function testPivotAttributCondition(): void
    {
        $this->testManyToMany();

        $customer = Customer::find('IVAN');
        $products = $customer->likeProductsLastWeek;

        foreach ($products as $product) {
            $pivot = $product->pivot;
            self::assertNotNull($pivot);
            self::assertNotNull($pivot->customer_id);
            self::assertNotNull($pivot->product_id);
            self::assertNotNull($pivot->created_at);
        }
    }

    public function testPivotModel(): void
    {
        $this->testManyToMany();

        $customer = Customer::find('IVAN');
        $products = $customer->likeProducts;

        foreach ($products as $product) {
            $pivot = $product->pivot;
            self::assertNotNull($pivot);
            self::assertNotNull($pivot->customer_id);
            self::assertNotNull($pivot->product_id);
            self::assertNotNull($pivot->created_at);

            self::assertNotNull($pivot->customer);
            self::assertNotNull($pivot->product);
        }
    }

    public function testOneToOnePolyMorphic(): void
    {
        $this->seed([CustomerSeeder::class, CategorySeeder::class, ProductSeeder::class, ImageSeeder::class]);

        $customer = Customer::find('Ivan');
        self::assertNotNull($customer);

        $image = $customer->image;
        self::assertNotNull($image);

        self::assertEquals('https://www.programmerzamannow.com/image/1.jpg', $image->url);
    }

    public function testEager(): void
    {
        $this->seed([CustomerSeeder::class, WalletSeeder::class, ImageSeeder::class]);

        $customer = Customer::with(['wallet', 'image'])->find("IVAN");
        self::assertNotNull($customer);
    }

    public function testEagerModel(): void
    {
        $this->seed([CustomerSeeder::class, WalletSeeder::class, ImageSeeder::class]);

        $customer = Customer::find("IVAN");
        self::assertNotNull($customer);
    }
}
