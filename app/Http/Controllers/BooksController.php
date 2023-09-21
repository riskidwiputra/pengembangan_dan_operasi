<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostBookRequest;
use App\Http\Resources\BookResource;
use App\Modules\Books\Interfaces\BooksServiceInterface;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    protected
    $booksService;
    public function __construct(
        BooksServiceInterface $booksService
        )
    {
        $this->booksService = $booksService;
    }

    public function index(Request $request)
    {
        
        try{

            $books = $this->booksService->getAll($request);
         
            return response()->json(['data' => BookResource::collection( $books )]);
           

        } catch (\Throwable $e) {

            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], $e->getCode() != 0 ? $e->getCode() : 400);
        
       }
    }

    public function store(PostBookRequest $request)
    {
        try{
           
            $books = $this->booksService->create($request);

            return response()->json(collect(BookResource::collection($books)),201);


        } catch (\Throwable $e) {

            return response()->json([
                'status'  => false,
                'message' => $e->getMessage()
            ], $e->getCode() != 0 ? $e->getCode() : 400);
        
       }
    }
}
