<?php

namespace App\Modules\Authors\Repositories;

use App\Models\Author;
use App\Modules\Authors\Interfaces\AuthorsRepositoryInterface;
use Illuminate\Support\Facades\DB;

class AuthorsRepository implements AuthorsRepositoryInterface
{
    protected $authors;

    public function __construct(Author $authors)
    {
        $this->authors = $authors;
    }

    public function findById($id)
    {
        return $this->authors->find($id);
    }
}
