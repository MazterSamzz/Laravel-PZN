<?php

namespace Tests\Feature;

use App\Data\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CollectionTest extends TestCase
{
    // ============================================ 04 Membuat Collection ============================================
    public function testCreateCollection(): void
    {
        $collection = collect([1, 2, 3]);
        $this->assertEqualsCanonicalizing([1, 2, 3], $collection->all());
    }

    // ============================================ 05 For Each ============================================
    public function testForEach(): void
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);

        foreach ($collection as $key => $value) {
            $this->assertEquals($key + 1, $value);
        }
    }

    // ============================================ 06 Manipulasi Collection ============================================
    public function testCrud(): void
    {
        $collection = collect([]);
        $collection->push(1, 2, 3);
        $this->assertEqualsCanonicalizing([1, 2, 3], $collection->all());

        $result = $collection->pop();
        $this->assertEquals(3, $result);
        $this->assertEqualsCanonicalizing([1, 2], $collection->all());
    }

    // ============================================ 07 Mapping ============================================
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

    // ============================================ 08 Zipping ============================================
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

    // ============================================ 09 Flattening ============================================
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

    // ============================================ 10 String Representation ============================================
    public function testStringRepresentation(): void
    {
        $collection = collect(['Samuel', 'Ivan', 'Kristyanto']);

        $this->assertEquals("Samuel-Ivan-Kristyanto", $collection->join('-'));
        $this->assertEquals("Samuel-Ivan_Kristyanto", $collection->join('-', '_'));
        $this->assertEquals("Samuel, Ivan and Kristyanto", $collection->join(', ', ' and '));
    }

    // ============================================ 11 Filtering ============================================
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

    // ============================================ 12 Partitioning ============================================
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

    // ============================================ 13 Testing ============================================
    public function testTesting(): void
    {
        $collection = collect(['Samuel', 'Ivan', 'Kristyanto']);

        $this->assertTrue($collection->contains('Samuel'));
        $this->assertTrue($collection->contains(function ($value, $key) {
            return $value == 'Kristyanto';
        }));
    }

    // ============================================ 14 Grouping ============================================
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

    // ============================================ 15 Slicing ============================================
    public function testSlice(): void
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);

        $result = $collection->slice(3);
        $this->assertEqualsCanonicalizing([4, 5, 6, 7, 8, 9], $result->all());

        $result = $collection->slice(3, 2);
        $this->assertEqualsCanonicalizing([4, 5], $result->all());
    }

    // ============================================ 16 Take and Skip ============================================
    public function testTake(): void
    {
        $collection = collect([1, 2, 3, 1, 2, 3, 1, 2, 3]);

        $result = $collection->take(3);
        $this->assertEqualsCanonicalizing([1, 2, 3], $result->all());

        $result = $collection->takeUntil(function ($value, $key) {
            return $value == 3;
        });
        $this->assertEquals([1, 2], $result->all());

        $result = $collection->takeWhile(function ($value, $key) {
            return $value < 3;
        });
        $this->assertEquals([1, 2], $result->all());
    }

    public function testSkip(): void
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);

        $result = $collection->skip(3);
        $this->assertEqualsCanonicalizing([4, 5, 6, 7, 8, 9], $result->all());

        $result = $collection->skipUntil(function ($value, $key) {
            return $value == 3;
        });
        $this->assertEqualsCanonicalizing([3, 4, 5, 6, 7, 8, 9], $result->all());

        $result = $collection->skipWhile(function ($value, $key) {
            return $value < 3;
        });
        $this->assertEqualsCanonicalizing([3, 4, 5, 6, 7, 8, 9], $result->all());
    }

    // ============================================ 17 Chunked ============================================
    public function testChunked(): void
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

        $result = $collection->chunk(3);

        $this->assertEqualsCanonicalizing([collect([1, 2, 3])], [$result->all()[0]]);
        $this->assertEqualsCanonicalizing([collect([4, 5, 6])], [$result->all()[1]]);
        $this->assertEqualsCanonicalizing([7, 8, 9], $result->all()[2]->all());
        $this->assertEqualsCanonicalizing([10], $result->all()[3]->all());
    }

    // ============================================ 18 Retrieve ============================================
    public function testFirst(): void
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

        $result = $collection->first();
        $this->assertEquals(1, $result);

        $result = $collection->first(function ($value, $key) {
            return $value > 5;
        });
        $this->assertEquals(6, $result);
    }

    public function testLast(): void
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

        $result = $collection->last();
        $this->assertEquals(10, $result);

        $result = $collection->last(function ($value, $key) {
            return $value < 5;
        });
        $this->assertEquals(4, $result);
    }

    // ============================================ 19 Random ============================================
    public function testRandom(): void
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
        $result = $collection->random();
        echo $result;
        $this->assertTrue(in_array($result, [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]));
    }

    // ============================================ 20 Checking Existance ============================================
    public function testCheckingExistence(): void
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
        $this->assertTrue($collection->isNotEmpty());
        $this->assertFalse($collection->isEmpty());
        $this->assertTrue($collection->contains(1));
        $this->assertFalse($collection->contains(0));
    }

    // ============================================ 21 Ordering ============================================
    public function testOrdering(): void
    {
        $collection = collect([1, 3, 2, 4, 6, 5, 7, 9, 8]);

        $result = $collection->sort();
        $this->assertEqualsCanonicalizing([1, 2, 3, 4, 5, 6, 7, 8, 9], $result->all());

        $result = $collection->sortDesc();
        $this->assertEqualsCanonicalizing([9, 8, 7, 6, 5, 4, 3, 2, 1], $result->all());
    }

    // ============================================ 22 Aggregate ============================================
    public function testAggregate(): void
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);

        $result = $collection->sum();
        $this->assertEquals(45, $result);

        $result = $collection->avg();
        $this->assertEquals(5, $result);

        $result = $collection->min();
        $this->assertEquals(1, $result);

        $result = $collection->max();
        $this->assertEquals(9, $result);
    }

    // ============================================ 23 Reduce ============================================
    public function testReduce(): void
    {
        $collection = collect([1, 2, 3, 4, 5, 6, 7, 8, 9]);

        $result = $collection->reduce(function ($carry, $item) {
            return $carry + $item;
        });
        $this->assertEquals(45, $result);

        // reduce(1,2) = 3
        // reduce(3,3) = 6
        // reduce(6,4) = 10
        // reduce(10,5) = 15
        // reduce(15,6) = 21
        // reduce(21,7) = 28
        // reduce(28,8) = 36
        // reduce(36,9) = 45

    }
}
