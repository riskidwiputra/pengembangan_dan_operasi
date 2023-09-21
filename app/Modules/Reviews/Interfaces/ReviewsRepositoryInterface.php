<?php

namespace App\Modules\Reviews\Interfaces;
interface ReviewsRepositoryInterface
{
    public function create(
        $id_book,
        $id_user,
        $review,
        $comment,
       
    );
    public function findBookReview($book_id,$review_id);
    public function destroy($book_id,$review_id);
}
