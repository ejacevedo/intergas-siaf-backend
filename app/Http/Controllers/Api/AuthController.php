<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
            return response(["token"=>$token], Response::HTTP_OK);

        } else {
            return response(["message"=> "Invalid credentials."],Response::HTTP_UNAUTHORIZED);
        }
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response(null, Response::HTTP_OK);
    }

    public function allUsers(Request $resquest) {

    }
}
