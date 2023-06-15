<?php 

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


use App\Repositories\UserRepository;
use App\Constants\Roles;

class UserController extends Controller
{

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $limit = $request->query('limit', 10);
            $users = $this->userRepository->getAll($limit);
            return response()->json($users, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'users.index.failed',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateRoles(Request $request, $username): JsonResponse {
        
        try {
            $request->validate([
                'roles' => 'required|array',
                'roles.*' => 'string|in:'.implode(',', [Roles::ROOT, Roles::ADMIN_QUOTE, Roles::QUOTE]),
            ]);
    
            $user = $this->userRepository->getByUsername($username);
            $roles = $request->input('roles');
            $this->userRepository->updateRoles($user,$roles);
            return response()->json(['message' => __('Roles updated successfully')]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'users.index.failed',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getRoles(Request $request): JsonResponse {
        
        try {
            $pageNumber = $request->query('page', 200);
            $roles = $this->userRepository->getAllRoles($pageNumber);
            return response()->json($roles, Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'users.roles.all.failed',
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    
}