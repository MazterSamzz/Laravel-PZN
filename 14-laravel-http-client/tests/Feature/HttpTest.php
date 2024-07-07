<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class HttpTest extends TestCase
{
    // private $url = "https://enh047rcf2az6.x.pipedream.net";
    private $url = "https://enayjtdq1a6bp.x.pipedream.net/";

    public function testGet(): void
    {
        $response = Http::get($this->url);
        self::assertTrue($response->ok());
    }

    public function testPost(): void
    {
        $response = Http::post($this->url);
        self::assertTrue($response->ok());
    }


    public function testDelete(): void
    {
        $response = Http::delete($this->url);
        self::assertTrue($response->ok());
    }

    public function testResponse()
    {
        $response = Http::get($this->url);
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
        ])->get($this->url);
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
        ])->get($this->url);
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
        ], "enh047rcf2az6.x.pipedream.net")->get($this->url);
        self::assertTrue($response->ok());
    }

    public function testFormPost(): void
    {
        $response = Http::asForm()->post($this->url, [
            "username" => "admin",
            "password" => "admin"
        ]);

        self::assertTrue($response->ok());
    }

    public function testMultipart(): void
    {
        $response = Http::asMultipart()
            ->attach("profile", file_get_contents(__DIR__ . '/../../resources/HP.jpg'), "profile.jpg")
            ->post($this->url, [
                "username" => "admin",
                "password" => "admin"
            ]);

        self::assertTrue($response->ok());
    }

    public function testJson(): void
    {
        $response = Http::asJson()
            ->post($this->url, [
                "username" => "admin",
                "password" => "admin"
            ]);

        self::assertTrue($response->ok());
    }

    public function testTimeout(): void
    {
        $response = Http::timeout(5)->asJson()
            ->post($this->url, [
                "username" => "admin",
                "password" => "admin"
            ]);

        self::assertTrue($response->ok());
    }

    public function testRetry(): void
    {
        $response = Http::timeout(1)->retry(5, 1000)->asJson()
            ->post($this->url, [
                "username" => "admin",
                "password" => "admin"
            ]);

        self::assertTrue($response->ok());
    }

    public function testThrowError(): void
    {
        $this->assertThrows(function () {
            $response = Http::get("https://programmerzamannow.com/not-found");
            self::assertEquals(404, $response->status());
            $response->throw();
        }, RequestException::class);
    }
}
