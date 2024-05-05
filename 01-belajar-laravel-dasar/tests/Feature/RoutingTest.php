<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutingTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/pzn');

        $response->assertStatus(200)->assertSeeText('Hello Programmer Zaman Now');
    }

    public function testFallback()
    {
        $this->get('tidakada')->assertSeeText('404 by Programmer Zaman Now');
        $this->get('tidakadalagi')->assertSeeText('404 by Programmer Zaman Now');
        $this->get('ups')->assertSeeText('404 by Programmer Zaman Now');
    }

    public function testRouteParameter()
    {
        $this->get('/products/1')->assertSeeText('Product 1');

        $this->get('/products/2')->assertSeeText('Product 2');

        $this->get('/products/1/items/xxx')->assertSeeText('Product 1, Item xxx');
    }

    public function testRouteParameterRegex()
    {
        $this->get('/categories/1')->assertSeeText('Category 1');

        $this->get('/categories/ivan')->assertSeeText('404 by Programmer Zaman Now');
    }

    public function testRouteParameterOptional()
    {
        $this->get('/users')->assertSeeText('User 404');
    }

    public function testRouteConflict(){
        $this->get('/conflict/budi')->assertSeeText("Conflict budi");
        $this->get('/conflict/eko')->assertSeeText('Conflict Eko Kurniawan Khannedy');
    }
}
