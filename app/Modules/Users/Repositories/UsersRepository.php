<?php

namespace App\Modules\users\Repositories;

use App\Models\User;
use App\Modules\Users\Interfaces\UsersRepositoryInterface;

class UsersRepository implements UsersRepositoryInterface
{
    protected $users;

    public function __construct(User $users)
    {
        $this->users = $users;
    }

    public function findById($id)
    {
        return $this->users->find($id);
    }
}
