<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileStorageTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testStorage(): void
    {
        $filesystem = Storage::disk('local');
        $filesystem->put('file.txt', 'Ivan Kristyanto');
        $content = $filesystem->get('file.txt');

        self::assertEquals('Ivan Kristyanto', $content);
    }
}
