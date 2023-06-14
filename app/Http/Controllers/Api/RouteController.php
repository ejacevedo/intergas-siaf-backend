<?php 

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Route;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use App\Lib\QuoteRoute;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Database\Query\Builder;

use Validator;
use Exception;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use App\Repositories\RouteRepository;


class RouteController extends Controller
{

    private $routeRepository;

    public function __construct(RouteRepository $routeRepository)
    {
        $this->routeRepository = $routeRepository;
    }

    public function index(Request $request)
    {
        try {
            $limit = $request->query('limit', 10);
            $routes = $this->routeRepository->getAll($limit);
            return response()->json($routes, 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'route.index.failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function quote(Request $request, QuoteRoute $quoteRoute)
    {
        try {
            $request->validate([
                'load_address_id' => 'required',
                'unload_address_id' => 'required',
                'return_address_id' => 'required'
            ]);

            $setting =  Setting::get()->first();
            if(empty($setting)) {
                throw new ModelNotFoundException(__('Your environment does not have the necessary configuration for quoting'));
            }

            $perPage = 10;
            $filters = [
                'load_address_id' => $request->load_address_id, 
                'unload_address_id' => $request->unload_address_id,
                'return_address_id' => $request->return_address_id,
            ];

            $routes = $this->routeRepository->getAll($perPage, $filters);
            $router = $routes->first();

            if(empty($router)) {
                throw new ModelNotFoundException(__('Selected addresses have no route for quotation'));
            }
            
            $router['liters'] = $quoteRoute->getLiters($router);
            $router['cost_travel'] = $quoteRoute->getCostTravel($router);
            $router['price_sale'] = $quoteRoute->getPriceSale($setting, $router);
            $router['cost_per_kilogram'] = $quoteRoute->getCostPerKilogram($setting, $router);
            $router['cost_per_liter'] = $quoteRoute->getCostPerliter($setting, $router);

            return response()->json($router, 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'router.index.failed',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function createBulk(Request $request)
    {
        try {
            $data = $request->all();
            $response = $this->routeRepository->createBulk($data);
            return response()->json($response , 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'router.index.createBulk',
                'message' => $e->getMessage()
            ], 400);
        }
    }

}