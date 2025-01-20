<?php

use App\Http\Controllers\GenreController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SubtitleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideoQualityController;
use App\Http\ExternalControllers\ProfilePictureController;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContentController;


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


Route::controller(UserController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('/users/{id}', 'show');
        Route::put('/users/{id}', 'update');
        Route::delete('/users/{id}', 'destroy');
        Route::get('/users/{id}/profiles', 'getProfiles');
        Route::post('/users', 'store');
        Route::get('/users', 'index');
    });


Route::controller(ProfileController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('/profiles', 'index');
        Route::post('/profiles', 'store');
        Route::get('/profiles/{id}', 'show');
        Route::put('/profiles/{id}', 'update');
        Route::delete('/profiles/{id}', 'destroy');
    });

Route::controller(PreferenceController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('/preferences', 'index');
        Route::post('/preferences', 'store');
        Route::get('/preferences/{id}', 'show');
        Route::put('/preferences/{id}', 'update');
        Route::delete('/preferences/{id}', 'destroy');
    });

Route::controller(VideoQualityController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('/video-qualities', 'index');
        Route::post('/video-qualities', 'store');
        Route::get('/video-qualities/{id}', 'show');
        Route::put('/video-qualities/{id}', 'update');
        Route::delete('/video-qualities/{id}', 'destroy');
    });

Route::controller(LanguageController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('/languages', 'index');
        Route::post('/languages', 'store');
        Route::get('/languages/{id}', 'show');
        Route::put('/languages/{id}', 'update');
        Route::delete('/languages/{id}', 'destroy');
    });

Route::controller(GenreController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('/genres', 'index');
        Route::post('/genres', 'store');
        Route::get('/genres/{id}', 'show');
        Route::put('/genres/{id}', 'update');
        Route::delete('/genres/{id}', 'destroy');
    });

Route::controller(SubtitleController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('/subtitles', 'index');
        Route::post('/subtitles', 'store');
        Route::get('/subtitles/{id}', 'show');
        Route::put('/subtitles/{id}', 'update');
        Route::delete('/subtitles/{id}', 'destroy');
    });

Route::controller(SubscriptionController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
        Route::get('/subscriptions', 'index');
        Route::post('/subscriptions', 'store');
        Route::get('/subscriptions/{id}', 'show');
        Route::put('/subscriptions/{id}', 'update');
        Route::delete('/subscriptions/{id}', 'destroy');
    });

Route::controller(ContentController::class)
    ->group(function () {
        Route::get('/content/{contentId}', 'getContent');
        Route::get('/content/movie/{contentId}', 'getMovie');
        Route::get('/content/series/{seriesId}', 'getSerie');
        Route::get('/content/{contentId}/subtitles', 'getSubtitles');
    });





Route::controller(ProfilePictureController::class)
    ->middleware('auth:sanctum')
    ->group(function () {
    Route::get('/profile-picture', 'random');
    Route::get('/profile-picture/{id}', 'show');
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
