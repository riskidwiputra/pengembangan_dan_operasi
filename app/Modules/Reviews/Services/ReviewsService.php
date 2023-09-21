<?php
namespace App\Modules\Reviews\Services;

use App\Modules\Reviews\Interfaces\ReviewsRepositoryInterface;
use App\Modules\Reviews\Interfaces\ReviewsServiceInterface;
use App\Modules\Users\Interfaces\UsersRepositoryInterface;
use Exception;

class ReviewsService implements ReviewsServiceInterface
{
    protected 
    $reviewsRepository,
    $usersRepository;

    public function __construct(
        ReviewsRepositoryInterface $reviewsRepository,
        UsersRepositoryInterface $usersRepository
    )
    {
        $this->reviewsRepository    = $reviewsRepository;
        $this->usersRepository      = $usersRepository;
    }

  
    public function create($book,$request)
    {
        try {

            $id_book = $book->id;
            $id_user = Auth()->user()->id ?? 1;
            $review = $request->review;
            $comment = $request->comment;

            $book = $this->reviewsRepository->create($id_book,$id_user,$review,$comment);
            
            return ['data'=>$book];
          
        } catch (\Exception $e) {


            throw new Exception($e->getMessage(), 400);
        }

    }
    public function CheckBookReview($id_book, $id_review){
        try{
            $check = $this->reviewsRepository->findBookReview($id_book, $id_review);
            if(!$check){

                throw new Exception("Book Review Tidak Ditemukan",404);

            }
        } catch (\Exception $e) {

            throw new Exception($e->getMessage(), $e->getCode());
        }
    }
    public function destroy($book, $review){
        try {
            
            $id_book = $book->id;
            $id_review = $review->id;

             $this->CheckBookReview($id_book,$id_review);

            return $this->reviewsRepository->destroy($id_book,$id_review);

            
          
        } catch (\Exception $e) {

            throw new Exception($e->getMessage(), $e->getCode());
        }
    }
   
}
