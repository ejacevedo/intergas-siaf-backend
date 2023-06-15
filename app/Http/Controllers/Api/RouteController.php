<?php 

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Models\Setting;
use App\Lib\QuoteRoute;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Repositories\RouteRepository;

use Validator;
use Exception;

class RouteController extends Controller
{

    private $routeRepository;

    public function __construct(RouteRepository $routeRepository)
    {
        $this->routeRepository = $routeRepository;
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $limit = $request->query('limit', 10);
            $routes = $this->routeRepository->getAll($limit);
            return response()->json($routes, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'route.index.failed',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function quote(Request $request, QuoteRoute $quoteRoute): JsonResponse
    {
        try {
            $request->validate([
                'load_address_id' => 'required',
                'unload_address_id' => 'required',
                'return_address_id' => 'required'
            ]);

            $setting =  Setting::get()->first();
            if(empty($setting)) {
                throw new ModelNotFoundException(__('Configuration problems, please try again in the next few minutes. If this error persists, contact your support team.'));
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
                throw new ModelNotFoundException(__('The selected addresses have no route enabled'));
            }
            
            $router['liters'] = $quoteRoute->getLiters($router);
            $router['cost_travel'] = $quoteRoute->getCostTravel($router);
            $router['price_sale'] = $quoteRoute->getPriceSale($setting, $router);
            $router['cost_per_kilogram'] = $quoteRoute->getCostPerKilogram($setting, $router);
            $router['cost_per_liter'] = $quoteRoute->getCostPerliter($setting, $router);

            return response()->json($router, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'router.index.failed',
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function createBulk(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $response = $this->routeRepository->createBulk($data);
            return response()->json($response , Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'router.index.createBulk',
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

}