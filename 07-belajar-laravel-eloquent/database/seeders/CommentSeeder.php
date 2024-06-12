<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createCommentForProduct('1');
        $this->createCommentForProduct('2');
        $this->createCommentForVoucher();
    }

    private function createCommentForProduct($id): void
    {
        $product = Product::find($id);

        $comment = new Comment();
        $comment->email = "MazterSamzz@product$id.com";
        $comment->title = "Product Title $id";
        $comment->commentable_id = $product->id;
        $comment->commentable_type = Product::class;
        $comment->save();
    }

    private function createCommentForVoucher(): void
    {
        $voucher = Voucher::first();

        $comment = new Comment();
        $comment->email = 'MazterSamzz@voucher.com';
        $comment->title = 'Voucher Title';
        $comment->commentable_id = $voucher->id;
        $comment->commentable_type = 'voucher';
        $comment->save();
    }
}
