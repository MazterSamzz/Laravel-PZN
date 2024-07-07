<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class HttpTest extends TestCase
{
    public function testGet(): void
    {
        $response = Http::get("https://enh047rcf2az6.x.pipedream.net");
        self::assertTrue($response->ok());
    }

    public function testPost(): void
    {
        $response = Http::post("https://enh047rcf2az6.x.pipedream.net");
        self::assertTrue($response->ok());
    }


    public function testDelete(): void
    {
        $response = Http::delete("https://enh047rcf2az6.x.pipedream.net");
        self::assertTrue($response->ok());
    }

    public function testResponse()
    {
        $response = Http::get("https://enh047rcf2az6.x.pipedream.net");
        self::assertEquals(200, $response->status());
        self::assertNotNull($response->body());

        $json = $response->json();
        self::assertTrue($json['success']);
    }

    public function testQueryParameters(): void
    {
        $response = Http::withQueryParameters([
            "page" => 1,
            "limit" => 10
        ])->get("https://enh047rcf2az6.x.pipedream.net");
        self::assertTrue($response->ok());
    }
}
