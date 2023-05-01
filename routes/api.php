<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\QuoteController;
use Illuminate\Support\Facades\DB;
use App\Models\Person;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/phpinfo', function () {
    phpinfo(); 
});

Route::get('/users', [UserController::class, 'index'])->middleware(["auth:sanctum"]);
Route::post('/users', [UserController::class, 'create']);
Route::get('/locations', [LocationController::class, 'index']);
Route::post('/locations', [LocationController::class, 'create']);
Route::get('/quotes', [QuoteController::class, 'index']);
Route::post('/quotes', [QuoteController::class, 'create']);
Route::post('/login', [QuoteController::class, 'create']);

Route::fallback(function(){
    return response()->json([
        'message' => 'Page not found. If the error persists, contact your system team'], 404);
});
