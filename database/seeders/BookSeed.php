<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $books = [
            [
                'title' => 'Big Family',
                'description' => 'Talk About big family'
            ]
        ];

        $userBooks = [
            [
                'book_id' => 1,
                'user_id' => 1
            ],
            [
                'book_id' => 1,
                'user_id' => 2
            ],
        ];

        $publishedBooks = [
            [
                'book_id' => 1,
                'user_id' => 3
            ]
        ];

        DB::table('user_books')->insert($userBooks);
        DB::table('books')->insert($books);
        DB::table('user_books')->insert($publishedBooks);
    }
}
