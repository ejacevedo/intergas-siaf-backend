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

    public function new_index(Request $request)
    {
        try {
            $pageNumber = $request->query('page', 200);
            $routes = $this->routeRepository->getAll($pageNumber, 100);
            return response()->json($routes, 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'route.index.failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    public function index(Request $request)
    {
        try {

            $routes = Route::when(request('load_address_id'), function ($query) {
                $query->where('load_address_id', request('load_address_id'));                      
            })->when(request('unload_address_id'), function ($query) {
                $query->where('unload_address_id', request('unload_address_id'));                      
            })->when(request('return_address_id'), function ($query) {
                $query->where('return_address_id', request('return_address_id'));                      
            })
            // ->with('loadAddress','unloadAddress', 'returnAddress')
            // ->whereHas('loadAddress', function ($query)  {
            //     $query->where('status', true);
            // })
            // ->whereHas('unloadAddress', function ($query)  {
            //     $query->where('status', true);
            // })
            // ->whereHas('returnAddress', function ($query)  {
            //     $query->where('status', true);
            // })
            ->latest()
            ->paginate();
            
            return response()->json($routes , 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'delivery_routes.index.failed',
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
                return response(null, 400);
            }

             // 'load_address_id',
            // 'unload_address_id',
            // 'return_address_id',

            $deliveryRoute = Route::where('load_address_id', $request->input('load_address_id'))
            ->where('unload_address_id', $request->input('unload_address_id'))
            ->where('return_address_id', $request->input('return_address_id'))
            ->with('load_address','unload_address', 'return_address')
            ->whereHas('load_address', function ($query)  {
                $query->where('status', true);
            })
            ->whereHas('unload_address', function ($query)  {
                $query->where('status', true);
            })
            ->whereHas('return_address', function ($query)  {
                $query->where('status', true);
            })
            ->first();

            if(empty($deliveryRoute)) {
                throw new ModelNotFoundException(__('Selected locations have no route for quotation'));
            }
            
            $deliveryRoute['liters'] = $quoteRoute->getLiters($deliveryRoute);
            $deliveryRoute['cost_travel'] = $quoteRoute->getCostTravel($deliveryRoute);
            $deliveryRoute['price_sale'] = $quoteRoute->getPriceSale($setting, $deliveryRoute);
            $deliveryRoute['cost_per_kilogram'] = $quoteRoute->getCostPerKilogram($setting, $deliveryRoute);
            $deliveryRoute['cost_per_liter'] = $quoteRoute->getCostPerliter($setting, $deliveryRoute);

            return response()->json($deliveryRoute, 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'quotes.index.failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function create(Request $request) {
        $quote = Route::create($request->all());
        // $quote =Route::insert($request->all());
        return response()->json($quote, 200);
    }


}