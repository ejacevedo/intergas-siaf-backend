<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quote;

use Validator;
use Exception;

class QuoteController extends Controller
{

    public function index(Request $request)
    {
        try {
            $quotes = Quote::when(request('point_a'), function ($query) {
                $query->where('point_a_location_id', request('point_a'));                      
            })->when(request('point_b'), function ($query) {
                $query->where('point_b_location_id', request('point_b'));                      
            })->when(request('point_c'), function ($query) {
                $query->where('point_c_location_id', request('point_c'));                      
            })
            ->latest()
            ->paginate();
            return response()->json($quotes , 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'quotes.index.failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function create(Request $request) {
        $quote = Quote::create($request->all());
        return response()->json($quote, 200);
    }


}