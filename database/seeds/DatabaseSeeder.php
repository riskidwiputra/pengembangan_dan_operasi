<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = App\Models\User::factory(5)->create();
        $users = App\Models\User::factory(5)->create();
        $post = App\Models\Post::factory(15)->create();
        $course = App\Models\Course::factory(15)->create();
        $video = App\Models\Video::factory(15)->create();

        App\Models\Author::factory(15)->create()->each(function (App\Models\Author $author) {
            App\Models\Book::factory(3)->create()->each(function (App\Models\Book $book) use ($author) {
                $book->authors()->saveMany([
                    $author,
                ]);
            });
        });

        \App\Models\Book::all()->each(function (App\Models\Book $book) use ($users) {
            $reviews = App\Models\BookReview::factory(4)->make();
            $contents = App\Models\BookContent::factory(1)->make();
            $reviews->each(function (\App\Models\BookReview $review) use ($users) {
                $review->user()->associate($users->random());
            });
            $book->reviews()->saveMany($reviews);
            $book->bookContents()->saveMany($contents);
        });
    }
}
