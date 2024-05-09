<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResponseControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testResponse(): void
    {
        $response = $this->get('/response/hello');

        $response->assertStatus(200)->assertSeeText('hello response');
    }

    public function testHeader(): void
    {
        $this->get('/response/header')
            ->assertStatus(200)
            ->assertSeeText('Ivan')->assertSeeText('Kristyanto')
            ->assertHeader('Content-Type', 'application/json')
            ->assertHeader('Author', 'Programmer Zaman Now');
    }

    public function testView()
    {
        $this->get('/response/type/view')->assertSeeText('Hello Ivan');
    }

    public function testJson()
    {
        $this->get('/response/type/json')->assertJson([
            'firstName' => 'Ivan',
            'lastName' => 'Kristyanto'
        ]);
    }

    public function testFile()
    {
        $this->get('/response/type/file')->assertHeader('Content-Type', 'image/jpeg');
    }

    public function testDownload()
    {
        $this->get('/response/type/download')->assertDownload('Samuel.jpg');
    }
}
