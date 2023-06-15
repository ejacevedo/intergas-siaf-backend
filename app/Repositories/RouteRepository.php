<?php

namespace App\Repositories;

use App\Models\Route;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;


class RouteRepository
{
    public function create(array $data): Route
    {
        return Route::create($data);
    }

    public function update(Route $route, array $data): Route
    {
        $route->update($data);
        return $route;
    }

    public function delete(Route $route): void 
    {
        $route->delete();
    }

    public function getById($id): Route
    {
        return Route::findOrFail($id);
    }

    public function getAll(int $pagination = 10, array $filters = [], array $search = []): LengthAwarePaginator
    {
        $query = QueryBuilder::for(Route::class)
            ->allowedFilters($this->getAllowedFilters())
            ->allowedIncludes('load_address', 'unload_address', 'return_address')
            ->defaultSort('-id');
            
        if (!empty($filters)) {
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
        $route = new Route();
        $columnsRoute = $route->getFillable();
        
        $allowedFilterRouter = array_map(function ($column) {
            return AllowedFilter::exact($column);
        }, $columnsRoute);

        array_push($allowedFilterRouter, AllowedFilter::exact('load_address.status'), AllowedFilter::exact('unload_address.status'), AllowedFilter::exact('return_address_id.status'));
        return $allowedFilterRouter;

    }
    
    public function clearAll(): void
    {
        Route::query()->delete();
    }

    public function createBulk(array $routes): void
    {
        Route::insert($routes);
    }
}