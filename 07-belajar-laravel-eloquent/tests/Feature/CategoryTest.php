<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
}
