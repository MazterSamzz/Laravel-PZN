<?php

namespace Tests\Feature;

use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class CommentTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testCreateComment(): void
    {
        $comment = new Comment();

        $comment->email = 'MazterSamzz@gmail.com';
        $comment->title = 'Sample Title';
        $comment->comment = ' Sample Comment ';

        $comment->save();
        Log::info(json_encode($comment));

        self::assertNotNull($comment->id);
    }

    public function testDefaultAttributeValues(): void
    {
        $comment = new Comment();
        $comment->email = 'MazterSamzz@gmail.com';

        $comment->save();

        self::assertNotNull($comment->id);
        self::assertNotNull($comment->title);
        self::assertNotNull($comment->comment);
    }
}
