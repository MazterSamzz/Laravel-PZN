<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Person;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PersonTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testPerson(): void
    {
        $person = new Person();
        $person->first_name = 'Ivan';
        $person->last_name = 'Kristyanto';
        $person->save();

        // $person->full_name memanggil function fullName() di Model Person
        self::assertEquals("IVAN Kristyanto", $person->full_name);

        $person->full_name = 'Skyline Vanelson';
        $person->save();

        self::assertEquals('SKYLINE', $person->first_name);
        self::assertEquals('Vanelson', $person->last_name);
    }

    public function testAttributeCasting()
    {
        $person = new Person();

        $person->first_name = 'Ivan';
        $person->last_name = 'Kristyanto';
        $person->save();

        self::assertNotNull($person->created_at);
        self::assertNotNull($person->updated_at);
        self::assertInstanceOf(Carbon::class, $person->created_at);
        self::assertInstanceOf(Carbon::class, $person->updated_at);
    }

    public function testCustomCasts(): void
    {
        $person = new Person();
        $person->first_name = "Ivan";
        $person->last_name = "Kristyanto";
        $person->address = new Address("Jalan belum jadi", "Jakarta", "Indonesia", "12345");
        $person->save();

        self::assertNotNull($person->created_at);
        self::assertNotNull($person->updated_at);
        self::assertInstanceOf(Carbon::class, $person->created_at);
        self::assertInstanceOf(Carbon::class, $person->updated_at);
        self::assertEquals("Jalan belum jadi", $person->address->street);
        self::assertEquals("Jakarta", $person->address->city);
        self::assertEquals("Indonesia", $person->address->country);
        self::assertEquals("12345", $person->address->postal_code);
    }
}
