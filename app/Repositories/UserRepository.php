<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function create(array $data)
    {
        return User::create($data);
    }

    public function update(User $user, array $data)
    {
        $user->update($data);
        return $user;
    }

    public function delete(User $user)
    {
        $user->delete();
    }

    public function getById($id)
    {
        return User::findOrFail($id);
    }

    public function getAll($page, $limit)
    {
        return User::all();
    }
}