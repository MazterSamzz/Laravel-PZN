<?php

namespace Tests\Feature;

use App\Data\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CollectionTest extends TestCase
{
    public function testCreateCollection(): void
    {
        $collection = collect([1, 2, 3]);
        $this->assertEqualsCanonicalizing([1, 2, 3], $collection->all());
    }

    public function testForEach(): void
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);

        foreach ($collection as $key => $value) {
            $this->assertEquals($key + 1, $value);
        }
    }

    public function testCrud(): void
    {
        $collection = collect([]);
        $collection->push(1, 2, 3);
        $this->assertEqualsCanonicalizing([1, 2, 3], $collection->all());

        $result = $collection->pop();
        $this->assertEquals(3, $result);
        $this->assertEqualsCanonicalizing([1, 2], $collection->all());
    }

    public function testMap(): void
    {
        $collection = collect([1, 2, 3]);
        $result = $collection->map(function ($item) {
            return $item * 2;
        });
        $this->assertEqualsCanonicalizing([2, 4, 6], $result->all());
    }

    public function testMapInto(): void
    {
        $collection = collect(['Ivan']);
        $result = $collection->mapInto(Person::class);

        $this->assertEquals([new Person("Ivan")], $result->all());
    }

    public function testMapSpread(): void
    {
        $collection = collect([
            ["Ivan", "Kristyanto"],
            ["Budi", "Saputra"]
        ]);

        $result = $collection->mapSpread(function ($firstName, $lastName) {
            $fullName = $firstName . " " . $lastName;
            return new Person($fullName);
        });

        $this->assertEquals([new Person("Ivan Kristyanto"), new Person("Budi Saputra")], $result->all());
    }

    public function testMapToGroups(): void
    {
        $collection = collect([
            [
                "name" => "Ivan",
                "departement" => "IT"
            ],
            [
                "name" => "Kris",
                "departement" => "IT"
            ],
            [
                "name" => "Budi",
                "departement" => "HR"
            ]
        ]);

        $result = $collection->mapToGroups(function ($person) {
            return [
                $person["departement"] => $person["name"]
            ];
        });

        $this->assertEquals([
            "IT" => collect(["Ivan", "Kris"]),
            "HR" => collect(["Budi"])
        ], $result->all());
    }

    public function testZip()
    {
        $collection1 = collect(1, 2, 3);
        $collection2 = collect(4, 5, 6);
        $collection3 = $collection1->zip($collection2);

        $this->assertEquals([
            collect([1, 4]),
            collect([2, 5]),
            collect([3, 6]),
        ], $collection3->all());
    }

    public function testConcat(): void
    {
        $collection1 = collect([1, 2, 3]);
        $collection2 = collect([4, 5, 6]);
        $collection3 = $collection1->concat($collection2);

        $this->assertEqualsCanonicalizing([1, 2, 3, 4, 5, 6], $collection3->all());
    }

    public function testCombine(): void
    {
        $collection1 = collect(['name', 'country']);
        $collection2 = collect(['Ivan', 'Indonesia']);
        $collection3 = $collection1->combine($collection2);

        $this->assertEqualsCanonicalizing([
            'name' => 'Ivan',
            'country' => 'Indonesia'
        ], $collection3->all());
    }
}
