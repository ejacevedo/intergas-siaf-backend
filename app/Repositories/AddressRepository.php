<?php

namespace App\Repositories;

use App\Models\Address;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class AddressRepository
{
    public function create(array $data)
    {
        return Address::create($data);
    }

    public function update(Address $user, array $data)
    {
        $user->update($data);
        return $user;
    }

    public function delete(Address $user)
    {
        $user->delete();
    }

    public function getById($id)
    {
        return Address::findOrFail($id);
    }

    public function getAll(int $pagination = 10, int $limit = null, array $filters = [])
    {
        $query = QueryBuilder::for(Address::class)
            ->allowedFilters($this->getAllowedFilters())
            ->defaultSort('-id');
        
        return$query->paginate($pagination);
    }

    public function clearAll()
    {
        return Address::truncate();
    }

    public function createBulk(array $addresses)
    {
        return Address::insert($addresses);
    }

    private function getAllowedFilters(): array
    {
        $columns = DB::getSchemaBuilder()->getColumnListing('addresses');

        return array_map(function ($column) {
            return AllowedFilter::exact($column);
        }, $columns);
    }


}