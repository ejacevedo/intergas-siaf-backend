<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{

    public function login(Request $request) {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if(Auth::attempt($credentials)){
            $user = Auth::user();
            
            if(!$user->status) {
                return response(["message"=>  __('auth.user_inactive')],Response::HTTP_UNAUTHORIZED);
            }

            if(!count($user->roles)) {
                return response(["message"=>  __('auth.roles_unauthorized')],Response::HTTP_UNAUTHORIZED);
            }

            $token = $user->createToken('token')->plainTextToken;
            return response([
                'token'=> $token, 
                'user' => $user
            ], Response::HTTP_OK);

        } else {
            return response(["message"=>  __('auth.failed')],Response::HTTP_UNAUTHORIZED);
        }
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response(null, Response::HTTP_OK);
    }

    public function allUsers(Request $resquest) {

    }

    public function changePassword(Request $request){
        $validated = $request->validate([
            'new_password'     => 'required',
            'password_confirmation' => 'required|same:new_password',
        ]);

        User::whereId(Auth::id())->update([
            'password' => Hash::make($request->new_password) 
        ]);

        return response()->json([
            'message' => 'Updated password.'
        ], 200);
    }
}
