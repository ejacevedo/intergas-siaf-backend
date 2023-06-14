<?php

namespace App\Repositories;

use App\Models\Route;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;


class RouteRepository
{
    public function create(array $data)
    {
        return Route::create($data);
    }

    public function update(Route $route, array $data)
    {
        $route->update($data);
        return $route;
    }

    public function delete(Route $route)
    {
        $route->delete();
    }

    public function getById($id)
    {
        return Route::findOrFail($id);
    }

    public function getAll(int $pagination = 10, array $filters = [], array $search = [])
    {
        $query = QueryBuilder::for(Route::class)
            ->allowedFilters($this->getAllowedFilters())
            ->allowedIncludes('load_address', 'unload_address', 'return_address')
            ->defaultSort('-id');
            
        if (!empty($filters)) {
            $query->allowedFilters(array_keys($filters));
            $query->where($filters);
        }

        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                foreach ($search as $field => $value) {
                    if(!empty($value)) {
                        $query->orWhere($field, 'LIKE', "%{$value}%");
                    }
                }
            });
        }

        return $query->paginate($pagination);
    }

    private function getAllowedFilters(): array
    {
        $columns = DB::getSchemaBuilder()->getColumnListing('routes');

        $response = array_map(function ($column) {
            return AllowedFilter::exact($column);
        }, $columns);


        array_push($response, AllowedFilter::exact('load_address.status'), AllowedFilter::exact('unload_address.status'), AllowedFilter::exact('return_address_id.status'));
        return $response;

    }
    
    public function clearAll()
    {
        return Route::truncate();
    }

    public function createBulk(array $routes)
    {
        return Route::insert($routes);
    }
}