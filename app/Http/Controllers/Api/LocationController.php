<?php 

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;

use Validator;
use Exception;

class LocationController extends Controller
{

    public function index(Request $request)
    {
        try {
            $locations = Location::when(request('filter'), function ($query) {
                $filter = request('filter');
                $query->where('name', 'like', "%$filter%");                       
            })
            ->orderBy('name')
           ->paginate(200);
           return response()->json($locations , 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'locations.index.failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function create(Request $request) {
        $location = Location::create($request->all());
        return response()->json($location, 200);
    }
    

}