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

    public function testCollapse(): void
    {
        $collection = collect([
            [1, 2, 3],
            [4, 5, 6],
            [7, 8, 9]
        ]);
        $result = $collection->collapse();

        $this->assertEqualsCanonicalizing([1, 2, 3, 4, 5, 6, 7, 8, 9], $result->all());
    }

    public function testFlatMap(): void
    {
        $collection = collect([
            [
                "name" => "Ivan",
                "hobbies" => ["Programming", "Gaming"]
            ],
            [
                "name" => "Kris",
                "hobbies" => ["Reading, Writing"]
            ]
        ]);

        $hobbies = $collection->flatMap(function ($item) {
            return $item['hobbies'];
        });

        $this->assertEqualsCanonicalizing(["Programming", "Gaming", "Reading, Writing"], $hobbies->all());
    }

    public function testStringRepresentation(): void
    {
        $collection = collect(['Samuel', 'Ivan', 'Kristyanto']);

        $this->assertEquals("Samuel-Ivan-Kristyanto", $collection->join('-'));
        $this->assertEquals("Samuel-Ivan_Kristyanto", $collection->join('-', '_'));
        $this->assertEquals("Samuel, Ivan and Kristyanto", $collection->join(', ', ' and '));
    }

    public function testFilter(): void
    {
        $collection = collect([
            'Ivan' => 100,
            'Kris' => 80,
            'Budi' => 90
        ]);

        $result = $collection->filter(function ($value, $key) {
            return $value >= 90;
        });

        $this->assertEquals([
            'Ivan' => 100,
            'Budi' => 90
        ], $result->all());
    }

    public function testFilterIndex(): void
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

        $result = $collection->filter(function ($value, $key) {
            return $value % 2 == 0;
        });

        $this->assertEqualsCanonicalizing([2, 4, 6, 8, 10], $result->all());
    }

    public function testPartitioning(): void
    {
        $collection = collect([
            'Ivan' => 100,
            'Kris' => 80,
            'Budi' => 90
        ]);

        [$result1, $result2] = $collection->partition(function ($value, $key) {
            return $value >= 90;
        });

        $this->assertEquals(['Ivan' => 100, 'Budi' => 90], $result1->all());
        $this->assertEquals(['Kris' => 80], $result2->all());
    }

    public function testTesting(): void
    {
        $collection = collect(['Samuel', 'Ivan', 'Kristyanto']);

        $this->assertTrue($collection->contains('Samuel'));
        $this->assertTrue($collection->contains(function ($value, $key) {
            return $value == 'Kristyanto';
        }));
    }

    public function testGrouping(): void
    {
        $collection = collect([
            [
                'name' => 'Ivan',
                'departement' => 'IT'
            ],
            [
                'name' => 'Kris',
                'departement' => 'IT'
            ],
            [
                'name' => 'Budi',
                'departement' => 'HR'
            ]
        ]);

        $result = $collection->groupBy('departement');

        $this->assertEquals([
            'IT' => collect([
                [
                    'name' => 'Ivan',
                    'departement' => 'IT'
                ],
                [
                    'name' => 'Kris',
                    'departement' => 'IT'
                ]
            ]),
            'HR' => collect([
                [
                    'name' => 'Budi',
                    'departement' => 'HR'
                ]
            ])
        ], $result->all());

        $result = $collection->groupBy(function ($value, $key) {
            return strtolower($value['departement']);
        });

        $this->assertEquals([
            'it' => collect([
                [
                    'name' => 'Ivan',
                    'departement' => 'IT'
                ],
                [
                    'name' => 'Kris',
                    'departement' => 'IT'
                ]
            ]),
            'hr' => collect([
                [
                    'name' => 'Budi',
                    'departement' => 'HR'
                ]
            ])
        ], $result->all());
    }
}
