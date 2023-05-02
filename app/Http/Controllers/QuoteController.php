<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\Settings;
use Illuminate\Support\Facades\DB;
use App\Lib\QuotationRules;

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

            $setting =  Settings::get()->first();

            if(empty($setting)) {
                return response(null, 400);
            }

            $quote = Quote::get()
            ->where('point_a_location_id', $request->input('point_a'))
            ->where('point_b_location_id', $request->input('point_b'))
            ->where('point_c_location_id', $request->input('point_c'))
            ->first();

            if(empty($quote)) {
                return response(null, 404);
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