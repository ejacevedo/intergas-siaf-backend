<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class UserController extends Controller
{

    public function index(Request $request)
    {
        try {
            $users = User::when(request('filter'), function ($query) {
                $filter = request('filter');
                $query->where('name', 'like', "%$filter%")
                ->orWhere('username', 'like', "%$$filter%")
                ->orWhere('status',  "%$$filter%");                           
            })->when(request('status'), function ($query) {
                $query->orWhere('status', request('status'));                        
            })
           ->latest()
           ->paginate();
           
           return response()->json( [ $users, Auth::user()] , 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'users.index.failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function create(Request $request) {
        $user = User::create($request->all());
        $response = [
            "token" => $user->createToken('systemWhatsapp')->plainTextToken,
            "user"  => $user
        ];
        return response()->json($response, 200);
    }
}