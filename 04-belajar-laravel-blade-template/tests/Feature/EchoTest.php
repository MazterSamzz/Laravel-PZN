<?php

namespace Tests\Feature;

use App\Models\Person;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EchoTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testEcho(): void
    {
        $person = new Person();
        $person->name = 'Ivan';
        $person->address = 'Semarang';

        $this->view('echo', ['person' => $person])
            ->assertSeeText('Ivan : Semarang');
    }
}
