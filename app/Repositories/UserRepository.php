<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;



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

    public function updateRoles(User $user, array $roles)
    {
        $user->syncRoles($roles);
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

    public function getAll(int $pagination = 10, int $limit = null, array $filters = [],  array $search = []) : LengthAwarePaginator
    {
        $query = QueryBuilder::for(User::class)
            ->allowedFilters($this->getAllowedFilters())
            ->allowedIncludes('roles')
            ->defaultSort('-id');

        if (isset($filters['search'])) {
            $query->where(function ($query) use ($filters) {
                $searchTerm = $filters['search'];
                $query->orWhere('name', 'like', "%{$searchTerm}%")
                    ->orWhere('username', 'like', "%{$searchTerm}%");
            });
            $query->with('roles');
        }

        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                foreach ($search as $field => $value) {
                    if(!empty($value)) {
                        $query->orWhere($field, 'LIKE', "%{$value}%");
                    }
                }
            });
            $query->with('roles');
        }

        if ($limit) {
            $query->limit($limit);
        }
         
        return $query->paginate($pagination);
        // return$query->paginate(2, ['*'], 'page', 2);
    }

    private function getAllowedFilters(): array
    {
        // $payment = new User();
        // $columns = $payment->getFillable();

        // return array_map(function ($column) {
        //     return 'filter[' . $column . ']';
        // }, $columns);

        $columns = DB::getSchemaBuilder()->getColumnListing('users');

        return array_map(function ($column) {
            // return 'filter[' . $column . ']';
            return AllowedFilter::exact($column);
        }, $columns);

    }

}