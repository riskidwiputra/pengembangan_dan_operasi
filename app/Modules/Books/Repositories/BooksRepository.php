<?php

namespace App\Modules\Books\Repositories;

use App\Models\Book;
use App\Modules\Books\Interfaces\BooksRepositoryInterface;
use Illuminate\Support\Facades\DB;

class BooksRepository implements BooksRepositoryInterface
{
    protected $books;

    public function __construct(Book $books)
    {
        $this->books = $books;
    }

    public function getAll(
        $limit=10,
        $title,
        $author,
        $sortTitle,
        $sortAverage 
    ){
        $books = $this->books
        ->when($title, function ($query) use ($title) {
            return $query->where('title', 'like', "%{$title}%");
        })
        ->when($author, function ($query) use ($author) {
            $query->whereHas('authors', function ($query) use ($author) {
                return $query->where('id', '=', $author);
            });
        })
        ->when($sortTitle, function ($query) use ($sortTitle) {
            $query->orderBy('title', $sortTitle);
        })
        ->when($sortAverage, function ($query) use ($sortAverage) {
            $query->withCount(['reviews as average_review' => function($query) {
                    $query->select(DB::raw('coalesce(avg(review),0)'));
            }])->orderBy('average_review',$sortAverage);
        })
        ->paginate($limit);
       
        $books->load('authors');
        $books->load('bookContents');
        $books->loadCount('reviews');
       
        return $books;
    }
    public function create(
        $isbn,
        $title,
        $description,
        $published_year,
        $price
    )
    {
       return $this->books->create([
            'isbn'              => $isbn,
            'title'             => $title,
            'description'       => $description,
            'published_year'    => $published_year,
            'price'             => $price
        ]);

    }
    public function getBook($id)
    {
        return $this->books->find($id);
    }
    
    public function createAuthors($author,$book_id){
        return $this->getBook($book_id)->authors()->attach($author);
    }

}
