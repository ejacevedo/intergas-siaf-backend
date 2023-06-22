<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class UserRepository
{
    public function newInstance(): User
    {
        return new User();
    }
    
    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }

    public function updateRoles(User $user, array $roles): User
    {
        $user->syncRoles($roles);
        return $user;
    }

    public function getById($id): User
    {
        return User::findOrFail($id);
    }

    public function getByUsername(string $username): User
    {
        return User::where('username', $username)->firstOrFail();
    }

    public function getAll(int $pagination = 10, array $filters = [],  array $search = []): LengthAwarePaginator
    {
        $query = QueryBuilder::for(User::class)
            ->allowedFilters($this->getAllowedFiltersForUser())
            ->allowedIncludes('roles')
            ->where('id', '!=', Auth::id())
            ->defaultSort('-id');

        if (!empty($filters['like'])) {
            $query->where(function ($query) use ($filters) {
                foreach ($filters['like'] as $field => $value) {
                    if (!empty($value)) {
                        $query->orWhere($field, 'LIKE', "%{$value}%");
                    }
                }
            });
            $query->with('roles');
        }

        if (!empty($filters['equal'])) {
            $query->where($filters['equal'])->with('roles');
        }

        return $query->paginate($pagination);
    }

    public function getAllRoles(int $pagination = 10,  array $search = []): LengthAwarePaginator
    {
        $query = QueryBuilder::for(Role::class)
            ->allowedFilters($this->getAllowedFiltersForRole())
            ->defaultSort('-id');

        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                foreach ($search as $field => $value) {
                    if (!empty($value)) {
                        $query->orWhere($field, 'LIKE', "%{$value}%");
                    }
                }
            });
        }
        
        return  $query->paginate($pagination);
    }

    protected function getAllowedFiltersForRole(): array
    {
        $role = new Role();
        $columns = $role->getFillable();

        return array_map(function ($column) {
            return AllowedFilter::exact($column);
        }, $columns);
    }

    protected function getAllowedFiltersForUser(): array
    {
        $user = new User();
        $columns = $user->getFillable();

        return array_map(function ($column) {
            return AllowedFilter::exact($column);
        }, $columns);
    }
}
