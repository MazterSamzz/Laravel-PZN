<?php

namespace Tests\Feature;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Psy\Command\WhereamiCommand;
use Tests\TestCase;

class QueryBuilderTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        DB::delete('delete from products');
        DB::delete('delete from categories');
    }
    public function testInsert(): void
    {
        DB::table('categories')->insert([
            [
                'id' => 'GADGET',
                'name' => 'Gadget'
            ]
        ]);

        DB::table('categories')->insert([
            [
                'id' => 'FOOD',
                'name' => 'Food'
            ]
        ]);

        $result = DB::select('select count(id) as total from categories');
        self::assertEquals(2, $result[0]->total);
    }

    public function testSelect(): void
    {
        $this->testInsert();

        $collection = DB::table('categories')->select(['id', 'name'])->get();
        self::assertNotNull($collection);

        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function insertCategories()
    {
        DB::table('categories')->insert([
            'id' => 'SMARTPHONE',
            'name' => 'Smartphone',
            'created_at' => '2024-01-01 00:00:00'
        ]);
        DB::table('categories')->insert([
            'id' => 'FOOD',
            'name' => 'Food',
            'created_at' => '2024-01-02 00:00:00'
        ]);
        DB::table('categories')->insert([
            'id' => 'LAPTOP',
            'name' => 'Laptop',
            'created_at' => '2024-01-03 00:00:00'
        ]);
        DB::table('categories')->insert([
            'id' => 'FASHION',
            'name' => 'Fashion',
            'created_at' => '2024-01-04 00:00:00'
        ]);
    }

    // where (column, operator, value)      || AND column operator value
    // where ([condition 1, condition 2])   || AND (condition 1 AND condition 2)
    // where (callback(Builder))            || AND (condition)
    // orWhere (column, operator, value)    || OR column operator value
    // orWhere ([condition 1, condition 2]) || OR (condition 1 OR condition 2)
    // orWhere (callback(Builder))          || OR (condition)
    // whereNot(callback(Builder))          || NOT (condition)
    public function testWhere(): void
    {
        $this->insertCategories();

        $collection = DB::table('categories')->where(function (Builder $builder) {
            $builder->where('id', '=', 'SMARTPHONE');
            $builder->orWhere('id', '=', 'FOOD');
            // SELECT * FROM categories WHERE id = 'SMARTPHONE' OR id = 'LAPTOP'
        })->get();

        self::assertCount(2, $collection);
        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    // whereBetween (column, [value1, value2])      || AND column BETWEEN value1 AND value2
    // whereNotBetween (column, [value1, value2])   || AND column NOT BETWEEN value1 AND value2
    public function testBetween(): void
    {
        $this->insertCategories();

        $collection = DB::table('categories')
            ->whereBetween('created_at', ['2024-01-01 00:00:00', '2024-01-03 23:59:59'])->get();

        self::assertCount(3, $collection);
        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    // whereIN (column, [array]) || AND column IN (array)
    // whereNotIN (column, [array]) || AND column NOT IN (array)
    public function testWhereIn(): void
    {
        $this->insertCategories();

        $collection = DB::table('categories')
            ->whereIn('id', ['SMARTPHONE', 'FOOD'])->get();

        self::assertCount(2, $collection);
        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    // whereNull (column)       || AND column IS NULL
    // whereNotNull (column)    || AND column IS NOT NULL
    public function testWhereNull(): void
    {
        $this->insertCategories();

        $collection = DB::table('categories')
            ->whereNull('description')->get();

        self::assertCount(4, $collection);
        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    // whereDate (column, date) || WHERE DATE(column) = date
    // whereDay (column, day) || WHERE DAY(column) = day
    // whereMonth (column, month) || WHERE MONTH(column) = month
    // whereYear (column, year) || WHERE YEAR(column) = year
    // whereTime (column, time) || WHERE TIME(column) = time
    public function testWhereDate(): void
    {
        $this->insertCategories();

        $collection = DB::table('categories')
            ->whereDate('created_at', '2024-01-01')->get();

        self::assertCount(1, $collection);
        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testUpdate(): void
    {
        $this->insertCategories();

        DB::table('categories')->where('id', '=', 'SMARTPHONE')
            ->update([
                'name' => 'Handphone',
            ]);

        $collection = DB::table('categories')->where('name', '=', 'Handphone')->get();
        self::assertCount(1, $collection);
    }

    public function testUpdateOrInsert(): void
    {
        $this->insertCategories();

        DB::table('categories')->updateOrInsert(
            [
                'id' => 'VOUCHER'
            ],
            [
                'name' => 'Voucher',
                'description' => 'Ticket and Voucher',
                'created_at' => '2024-01-05 00:00:00'
            ]
        );

        $collection = DB::table('categories')->where('id', '=', 'VOUCHER')->get();
        self::assertCount(1, $collection);
        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testIncrement(): void
    {
        DB::table('counters')->where('id', '=', 'sample')->increment('counter', 1);

        $collection = DB::table('counters')->where('id', '=', 'sample')->get();
        self::assertCount(1, $collection);
        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testDelete(): void
    {
        $this->insertCategories();
        DB::table('categories')->where('id', '=', 'SMARTPHONE')->delete();

        $collection = DB::table('categories')->where('id', '=', 'SMARTPHONE')->get();
        self::assertCount(0, $collection);
    }

    public function insertProducts()
    {
        $this->insertCategories();

        DB::table('products')->insert([
            'id' => '1',
            'name' => 'Iphone 14 Pro Max',
            'category_id' => 'SMARTPHONE',
            'price' => 20000000
        ]);
        DB::table('products')->insert([
            'id' => '2',
            'name' => 'Samsung Galaxy S21 Ultra',
            'category_id' => 'SMARTPHONE',
            'price' => 18000000
        ]);
    }

    public function testJoin(): void
    {
        $this->insertProducts();

        $collection = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.id', 'products.name', 'categories.name as category_name')
            ->get();
        self::assertCount(2, $collection);
        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }

    public function testOrdering()
    {
        $this->insertProducts();

        $collection = DB::table('products')->whereNotNull('id')
            ->orderBy('price', 'desc')->orderBy('name', 'asc')->get();

        self::assertCount(2, $collection);
        $collection->each(function ($item) {
            Log::info(json_encode($item));
        });
    }
}
