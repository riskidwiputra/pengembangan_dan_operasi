<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostBookReviewRequest;
use App\Http\Resources\BookReviewResource;
use App\Models\Book;
use App\Models\BookReview;
use App\Modules\Books\Interfaces\BooksServiceInterface;
use App\Modules\Reviews\Interfaces\ReviewsServiceInterface;
use Illuminate\Http\Request;

class BooksReviewController extends Controller
{
    protected
    $ReviewService;
    public function __construct(
        ReviewsServiceInterface $ReviewService
        )
    {
        $this->ReviewService = $ReviewService;
    }
    
    public function store(Book $id, PostBookReviewRequest $request)
    {
        try{
           
        $review = $this->ReviewService->create($id,$request);

        return response()->json(BookReviewResource::collection($review),201);
        
        } catch (\Throwable $e) {

            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], $e->getCode() != 0 ? $e->getCode() : 400);
        
       }
    }

    public function destroy(Book $bookId, BookReview $reviewId, Request $request)
    {
        try{
        
             $delete =  $this->ReviewService->destroy($bookId,$reviewId);

            return response()->json($delete, 204);
    
            } catch (\Exception $e) {
                return response()->json([
                    'status'  => false,
                    'message' => $e->getMessage()
                ], $e->getCode() != 0 ? $e->getCode() : 400);
            
           }
    }
}
