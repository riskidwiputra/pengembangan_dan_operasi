<?php

namespace App\Modules\Books\Interfaces;
interface BooksRepositoryInterface
{
    public function getAll( 
        $limit,
        $title,
        $author,
        $sortTitle,
        $sortAverage
    );
    public function create(
        $isbn,
        $title,
        $description,
        $published_year,
        $price
    );
    public function getBook($id);
    public function createAuthors($author,$book_id);
    // public function findById($id);
    // public function update($data, $id);
    // public function delete($id);
 

}
