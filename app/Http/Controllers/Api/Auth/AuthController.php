<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        if (Auth::attempt($request->validated())) {
            $user = Auth::user();

            /** @var \App\Models\User $user **/
            $roles = $user->getRoleNames()->toArray();

            if (!$user->status) {
                return response()->json(["message" =>  __('auth.user_inactive')], Response::HTTP_UNAUTHORIZED);
            }

            if (!count($user->roles)) {
                return response()->json(["message" =>  __('auth.roles_unauthorized')], Response::HTTP_UNAUTHORIZED);
            }

            $token = $user->createToken('token')->plainTextToken;
            return response()->json([
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'username' => $user->username,
                    'status' => $user->status,
                    'roles' => $roles,
                ],
            ], Response::HTTP_OK);
        } else {
            return response()->json(["message" =>  __('auth.failed')], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(null, Response::HTTP_OK);
    }

    public function changePassword(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'new_password'     => 'required',
            'password_confirmation' => 'required|same:new_password',
        ]);

        User::whereId(Auth::id())->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'message' => __('Updated password.')
        ], Response::HTTP_OK);
    }
}
