<?php

namespace App\Modules\Books\Interfaces;
interface BooksServiceInterface
{
    public function getAll($request);
    public function create($request);
    // public function update($request,$Products);
    // public function delete($id);
    // public function findById($Product);

}
