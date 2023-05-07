<?php

namespace App\Http\Controllers\Api;

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
            $token = $user->createToken('token')->plainTextToken;
            // $cookie = cookie('cookie_token', $token, 60 * 24);
            // return response(["token"=>$token], Response::HTTP_OK)->withoutCookie($cookie);
            return response([
                'token'=>$token, 
                'roles' => ['super admin', 'cotizador', 'admin cotizado'] 
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
