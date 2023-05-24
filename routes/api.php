<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\QuoteController;
use App\Http\Controllers\Api\LocationController;


use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\RouteController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function(){
    Route::get('/users', [UserController::class, 'index']);

    Route::get('/users2', [UserController::class, 'new_index']);

    Route::post('/users', [UserController::class, 'create']);
    Route::patch('/users/{id}/roles', [UserController::class, 'assignRole']);
    
    Route::get('/locations', [LocationController::class, 'index']);
    Route::post('/locations', [LocationController::class, 'create']);

    Route::get('/addresses', [AddressController::class, 'index']);
    Route::post('/addresses', [AddressController::class, 'create']);

    // Route::get('/addresses2', [AddressController::class, 'new_index']);

    Route::get('/quotes', [QuoteController::class, 'index']);
    Route::post('/quotes', [QuoteController::class, 'create']);
    Route::post('/quotes/build', [QuoteController::class, 'build']);

    Route::get('/routes', [RouteController::class, 'new_index']);
    Route::post('/routes', [RouteController::class, 'create']);
    Route::post('/routes/quote', [RouteController::class, 'quote']);

    
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/change_password', [AuthController::class, 'changePassword']);
});

Route::fallback(function(){
    return response()->json([
        'message' => 'Endpoint not found. If the error persists, contact your system team'], 404);
});
