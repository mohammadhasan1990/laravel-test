<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('/sites', \App\Http\Controllers\SiteController::class);

    Route::get('/subscriber-posts/latest/list', [\App\Http\Controllers\SubscriberPostController::class, 'latestIndex']);
    Route::get('/subscriber-posts/list', [\App\Http\Controllers\SubscriberPostController::class, 'index']);
    Route::get('/subscriber-posts/{siteId}/list', [\App\Http\Controllers\SubscriberPostController::class, 'indexOfSpecifySite']);

    Route::get('/publish-posts/check', [\App\Http\Controllers\PostController::class, 'prepareToSendToNotSentUsers']);
    Route::get('/publish-posts/latest/list', [\App\Http\Controllers\PostController::class, 'latestIndex']);
    Route::get('/publish-posts/{siteId}/list', [\App\Http\Controllers\PostController::class, 'indexOfSpecifySite']);
    Route::resource('/publish-posts', \App\Http\Controllers\PostController::class);

    Route::get('/subscribe/list', [\App\Http\Controllers\SubscriberController::class, 'index']);
    Route::post('/subscribe', [\App\Http\Controllers\SubscriberController::class, 'subscribe']);
});

