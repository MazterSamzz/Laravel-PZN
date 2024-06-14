<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InputControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testInput(): void
    {
        $this->get('/input/hello?name=Ivan')->assertSeeText('Hello Ivan');
        $this->post('/input/hello', ['name' => 'Ivan'])->assertSeeText('Hello Ivan');
    }

    public function testInputNested(): void
    {
        $this->post('/input/hello/first', ['name' => ['first' => 'Ivan', 'last' => 'Kristyanto']])->assertSeeText('Hello Ivan');
    }

    public function testHelloInput(): void
    {
        $this->post('input/hello/input', [
            'name' => [
                'first' => 'Ivan',
                'last' => 'Kristyanto',
            ]
        ])->assertSeeText('name')
            ->assertSeeText('first')
            ->assertSeeText('Ivan')
            ->assertSeeText('last')
            ->assertSeeText('Kristyanto');
    }

    public function testInputArray(): void
    {
        $this->post('/input/hello/array', [
            'products' => [
                [
                    'name' => 'Apple Mac Book Pro',
                    'price' => 30000000
                ],
                [
                    'name' => 'Samsung Galaxy S10',
                    'price' => 15000000
                ],
            ]
        ])->assertSeeText('Apple Mac Book Pro')
            ->assertSeeText('Samsung Galaxy S10');
    }

    public function testInputType(): void
    {
        $this->post('/input/type', [
            'name' => 'Budi',
            'married' => true,
            'birth_date' => '1990-01-10',
        ])->assertSeeText('Budi')
            ->assertSeeText('true')
            ->assertSeeText('1990-01-10');
    }

    public function testInputFilterOnly(): void
    {
        $this->post('/input/filter/only', ['name' => [
            'first' => 'Ivan',
            'middle' => 'Samuel',
            'last' => 'Kristyanto'
        ]])->assertSeeText('Ivan')
            ->assertSeeText('Kristyanto')
            ->assertDontSeeText('Samuel');
    }

    public function testInputFilterExcept(): void
    {
        $this->post('/input/filter/except', [
            'username' => 'MazterSamzz',
            'admin' => true,
            'password' => 'secret'
        ])->assertDontSeeText('admin');
    }

    public function testInputFilterMerge(): void
    {
        $this->post('input/filter/merge', [
            'username' => 'MazterSamzz',
            'password' => 'secret',
            'admin' => true
        ])->assertSeeText('MazterSamzz')
            ->assertSeeText('secret')
            ->assertSeeText('admin')
            ->assertSeeText('false');
    }
}
