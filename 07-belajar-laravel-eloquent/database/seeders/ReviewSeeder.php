<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i < 6; $i++) {
            $review = new Review();
            $review->product_id = $i;
            $review->customer_id = 'IVAN';
            $review->rating = $i;

            switch ($i) {
                case 1:
                    $review->comment = 'Jelek';
                    break;
                case 2:
                    $review->comment = 'Lumayan';
                    break;
                case 3:
                    $review->comment = 'Oke';
                    break;
                case 4:
                    $review->comment = 'Bagus';
                    break;
                case 5:
                    $review->comment = 'Luar Biasa';
                    break;
            }

            $review->save();
        }
    }
}
