<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class LoggingTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_Logging(): void
    {
        Log::info('Hello Info');
        Log::warning('Hello Warning');
        Log::error('Hello Error');
        Log::critical('Hello Critical');

        self::assertTrue(true);
    }

    public function testContext(): void
    {
        Log::info('Hello Info', ['User' => 'Khannedy']);
        self::assertTrue(true);
    }

    public function testWithContext(): void
    {
        Log::withContext([['user' => 'Ivan'], ['level' => 'admin']])->info('Hello Info');

        Log::info('Hello Info');
        Log::info('Hello Info');
        Log::info('Hello Info');

        self::assertTrue(true);
    }

    public function testChannel(): void
    {
        $slackLogger = Log::channel('slack');
        $slackLogger->error('Hello Slack'); // send to slack channel

        Log::info('Hello Laravel'); // send to default channel
        self::assertTrue(true);
    }
}
