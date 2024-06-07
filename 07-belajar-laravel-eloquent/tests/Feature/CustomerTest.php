<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Wallet;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\WalletSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
}
