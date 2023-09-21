<?php
namespace App\Modules\Books\Services;

use App\Jobs\RetreiveBookContentsJob;
use App\Modules\Authors\Interfaces\AuthorsRepositoryInterface;
use App\Modules\Books\Interfaces\BooksRepositoryInterface;
use App\Modules\Books\Interfaces\BooksServiceInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class BooksService implements BooksServiceInterface
{
    protected 
    $booksRepository,
    $authorRepository;

    public function __construct(
        BooksRepositoryInterface $booksRepository,
        AuthorsRepositoryInterface $authorRepository
    )
    {
        $this->booksRepository  = $booksRepository;
        $this->authorRepository = $authorRepository;
    }

    public function getAll($request){
        
        try{

            $limit = $request->limit;
            $title = $request->title;
            $author = $request->author;
            $sortTitle = $request->sortTitle;
            $sortAverage = $request->sortAverage;
      
            $book = $this->booksRepository->getAll(
                $limit,
                $title,
                $author,
                $sortTitle,
                $sortAverage
            );
            return  $book;

        } catch (\Exception $e) {

            throw new Exception($e->getMessage(), 400);
        }

    }

    public function create($request)
    {
        try {

            // DB::beginTransaction();

            $book = $this->booksRepository->create(
                $request->isbn,
                $request->title,
                $request->description,
                $request->published_year,
                $request->price,

            );
            // $this->authorRepository->findById($request->authors);

            $this->booksRepository->createAuthors($request->authors,$book->id);

            // DB::commit();

            RetreiveBookContentsJob::dispatch($book);

            return [
                 'data' => $book
            ];

        } catch (\Exception $e) {

            // DB::rollBack();

            throw new Exception($e->getMessage(), 400);
        }

    }

    // public function update($request, $products){

    //     try {
             
    //         if(!$this->booksRepository->findById($products->id)){
    //             throw new \Exception("Product Tidak Ditemukan", 404);
    //         }
    //         $data = [
    //            'name'   => $request->name,
    //            'description' => $request->description,
    //            'price'  => $request->price,

    //         ];
    //         return  $this->booksRepository->update($data,$products->id);

    //     } catch (\Exception $e) {

    //         throw new Exception($e->getMessage(), $e->getCode() ?? 409);
    //     }
    // }

    // public function delete($product){
    //     try {
             
    //         if(!$this->booksRepository->findById($product->id)){
    //             throw new \Exception("Product Tidak Ditemukan", 404);
    //         }

    //         return  $this->booksRepository->delete($product->id);

    //     } catch (\Exception $e) {

    //         throw new Exception($e->getMessage(), $e->getCode() ?? 409);
    //     }
    // }

    // public function findById($product){
    //     try {
             
    //         if(!$getProdutct = $this->booksRepository->findById($product->id)){
    //             throw new \Exception("Product Tidak Ditemukan", 404);
    //         }

    //         return  $getProdutct;

    //     } catch (\Exception $e) {

    //         throw new Exception($e->getMessage(), $e->getCode() ?? 409);
    //     }
    // }

   
}
