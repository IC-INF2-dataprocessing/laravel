<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::controller(AuthController::class)->group(function() {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
});

Route::controller(UserController::class)->group(function() {
    Route::get('/users/{id}', 'show');
    Route::put('/users/{id}', 'update');
    Route::get('/users/{id}/profiles', 'getProfiles');
});

Route::controller(ProfileController::class)->group(function () {
    Route::post('/profiles', 'store');
    Route::get('/profiles/{id}', 'show');
    Route::put('/profiles/{id}', 'update');
    Route::delete('/profiles/{id}', 'destroy');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/validate-token', function (Request $request) {
    return response()->json([
        'valid' => true,
        'user' => $request->user(),
    ]);
});

