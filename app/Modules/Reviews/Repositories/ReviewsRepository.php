<?php

namespace App\Modules\Reviews\Repositories;

use App\Models\BookReview;
use App\Modules\Reviews\Interfaces\ReviewsRepositoryInterface;

class ReviewsRepository implements ReviewsRepositoryInterface
{
    protected $review;

    public function __construct(BookReview $review)
    {
        $this->review = $review;
    }

    
    public function create(
        $id_book,
        $id_user,
        $review,
        $comment,
    )
    {
       return $this->review->create([
            'book_id'             => $id_book,
            'user_id'             => $id_user,
            'review'              => $review,
            'comment'             => $comment,
        ]);

    }
    public function findBookReview($book_id,$review_id){
        return $this->review->where('id',$review_id)->where('book_id',$book_id)->first();
    }
    public function destroy($book_id,$review_id){
        $review = $this->review->where('id',$review_id)->where('book_id',$book_id)->delete();
        return $review ?? false;
    }


}
