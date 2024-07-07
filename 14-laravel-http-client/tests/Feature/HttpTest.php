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

    public function testHeader(): void
    {
        $response = Http::withQueryParameters([
            "page" => 1,
            "limit" => 10
        ])->withHeaders([
            "accept" => "application/json",
            "x-request-ID" => '123123123',
        ])->get("https://enh047rcf2az6.x.pipedream.net");
        self::assertTrue($response->ok());
    }

    public function testCookie(): void
    {
        $response = Http::withQueryParameters([
            "page" => 1,
            "limit" => 10
        ])->withHeaders([
            "accept" => "application/json",
            "x-request-ID" => '123123123'
        ])->withCookies([
            "SessionId" => "3242432423",
            "UserId" => "ivan"
        ], "enh047rcf2az6.x.pipedream.net")->get("https://enh047rcf2az6.x.pipedream.net");
        self::assertTrue($response->ok());
    }

    public function testFormPost(): void
    {
        $response = Http::asForm()->post("https://enh047rcf2az6.x.pipedream.net", [
            "username" => "admin",
            "password" => "admin"
        ]);

        self::assertTrue($response->ok());
    }

    public function testMultipart(): void
    {
        $response = Http::asMultipart()
            ->attach("profile", file_get_contents(__DIR__ . '/../../resources/HP.jpg'), "profile.jpg")
            ->post("https://enh047rcf2az6.x.pipedream.net", [
                "username" => "admin",
                "password" => "admin"
            ]);

        self::assertTrue($response->ok());
    }

    public function testJson(): void
    {
        $response = Http::asJson()
            ->post("https://enh047rcf2az6.x.pipedream.net", [
                "username" => "admin",
                "password" => "admin"
            ]);

        self::assertTrue($response->ok());
    }
}
