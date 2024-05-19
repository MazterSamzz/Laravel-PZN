<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EachTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $this->view('each.each', ['users' => [
            [
                'name' => 'Ivan',
                'hobbies' => ['Coding', 'Gaming']
            ],
            [
                'name' => 'Skyline',
                'hobbies' => ['Drinking Milk', 'Sleeping']
            ]
        ]])->assertSeeInOrder(['.red', 'Ivan', 'Coding', 'Gaming', 'Skyline', 'Drinking Milk', 'Sleeping']);
    }
}
