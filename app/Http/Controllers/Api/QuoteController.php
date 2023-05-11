<?php 

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use App\Lib\QuotationRules;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    public function build(Request $request, QuotationRules $quotationRules)
    {
        try {

            $request->validate([
                'point_a' => 'required',
                'point_b' => 'required',
                'point_c' => 'required'
            ]);

            $setting =  Setting::get()->first();

            if(empty($setting)) {
                return response(null, 400);
            }

            $quote = Quote::where('point_a_location_id', $request->input('point_a'))
            ->where('point_b_location_id', $request->input('point_b'))
            ->where('point_c_location_id', $request->input('point_c'))
            ->with('location_a','location_b', 'location_c')
            ->first();

            if(empty($quote)) {
                throw new ModelNotFoundException('Selected locations have no route for quotation');
            }
            
            
            $quote['liters'] = $quotationRules->getLiters($quote);
            $quote['cost_travel'] = $quotationRules->getCostTravel($quote);
            $quote['price_sale'] = $quotationRules->getPriceSale($setting, $quote);
            $quote['cost_per_kilogram'] = $quotationRules->getCostPerKilogram($setting, $quote);
            $quote['cost_per_liter'] = $quotationRules->getCostPerliter($setting, $quote);

            return response()->json($quote, 200);
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