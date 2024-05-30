<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function testInsert(): void
    {
        $category = new Category();

        $category->id = 'GADGET';
        $category->name = 'Gadget';
        $result = $category->save();

        self::assertTrue($result);
    }

    public function testInsertManyCategories(): void
    {
        $categories = [];

        for ($i = 0; $i < 10; $i++) {
            $categories[] = [
                "id" => "ID $i",
                "name" => "Category $i"
            ];
        }

        // $result = Category::query()->insert($categories);
        $result = Category::insert($categories);

        self::assertTrue($result);

        // $total = Category::query()->count();
        $total = Category::count();
        self::assertEquals(10, $total);
    }

    public function testFind(): void
    {
        $this->seed("CategorySeeder");

        // $category = Category::query()->find("FOOD");
        $category = Category::find("FOOD");

        self::assertNotNull($category);
        self::assertEquals("FOOD", $category->id);
        self::assertEquals("Food", $category->name);
        self::assertEquals("Food Category", $category->description);
    }

    public function testUpdate(): void
    {
        $this->seed("CategorySeeder");

        $category = Category::find("FOOD");
        $category->name = "Food Update";

        $result = $category->save();
        self::assertTrue($result);
    }

    public function testSelect(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $category = new Category();

            $category->id = "ID $i";
            $category->name = "Category $i";
            $category->save();
        }

        $categories = Category::whereNull("description")->get();

        self::assertEquals(5, $categories->count());

        $categories->each(function ($category) {
            self::assertNull($category->description);

            $category->description = "updated";
            $category->update();

            Log::info(json_encode($category));
        });
    }

    public function testUpdateMany(): void
    {
        $categories = [];
        for ($i = 0; $i < 10; $i++) {
            $categories[] = [
                "id" => "ID $i",
                "name" => "Category $i"
            ];
        }

        $result = Category::insert($categories);
        self::assertTrue($result);

        Category::whereNull("description")->update([
            "description" => "updated"
        ]);

        $total = Category::where("description", "updated")->count();
        self::assertEquals(10, $total);
    }

    public function testDelete(): void
    {
        $this->seed("CategorySeeder");

        $category = Category::find("FOOD");
        $result = $category->delete();
        self::assertTrue($result);

        $total = Category::count();
        self::assertEquals(0, $total);
    }
}
