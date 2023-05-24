<?php 

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


use App\Repositories\UserRepository;


class UserController extends Controller
{

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function new_index(Request $request)
    {
        try {
            $pageNumber = $request->query('page', 200);
            $users = $this->userRepository->getAll($pageNumber);
            return response()->json($users, 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'users.index.failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

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
           ->paginate(200);
           return response()->json($users, 200);
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

    public function assignRole(Request $request, $id) {
        // $response = [
        //     "userId" => $id,
        //     "data"  => $request->all()
        // ];
        return response()->json([
            'message' => 'Successfully assigned roles'
        ], 200);
        // return response()->json($response, 200);
    }

    
}