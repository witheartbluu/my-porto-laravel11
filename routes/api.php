<?php

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\AuthController;
// use App\Http\Controllers\BlogApiController;
// use App\Http\Controllers\BlogController;


// // Public routes
// Route::post('/login', [AuthController::class, 'login']);
// Route::get('/blogs', [BlogApiController::class, 'index']);
// Route::get('/blogs/{id}', [BlogApiController::class, 'show']);

// // Protected routes
// Route::middleware(['jwt.auth'])->group(function () {
//     Route::post('/blogs', [BlogApiController::class, 'store']);
//     Route::put('/blogs/{id}', [BlogApiController::class, 'update']);
//     Route::delete('/blogs/{id}', [BlogApiController::class, 'destroy']);
//     Route::post('/logout', [AuthController::class, 'logout']);
//     Route::get('/me', [AuthController::class, 'me']);
//     Route::get('/blogs/{id}', [BlogController::class, 'show']);
// });

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogApiController; // we'll use ONE controller

// ---------- Public (no auth) ----------
Route::post('/login', [AuthController::class, 'login']);

Route::get('/blogs',      [BlogApiController::class, 'index']);  // list for users
Route::get('/blogs/{id}', [BlogApiController::class, 'show']);   // detail for users

// ---------- Admin (JWT protected) ----------
Route::middleware(['jwt.auth'])->group(function () {
    Route::post('/blogs',        [BlogApiController::class, 'store']);
    Route::put('/blogs/{id}',    [BlogApiController::class, 'update']);
    Route::delete('/blogs/{id}', [BlogApiController::class, 'destroy']);

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me',      [AuthController::class, 'me']);
});

// IMPORTANT:
// - Do NOT define Route::apiResource('blogs', ...) elsewhere.
// - Do NOT re-declare GET /blogs or GET /blogs/{id} inside the auth group.
// - Temporarily STOP using BlogController entirely.
use Illuminate\Support\Str;

Route::get('/debug/jwt', function () {
    return response()->json([
        'app_key_present'   => !empty(config('app.key')),
        'jwt_secret_present'=> !empty(env('JWT_SECRET')),
        'jwt_secret_head'   => env('JWT_SECRET') ? Str::limit(env('JWT_SECRET'), 8, '…') : null,
        'guard_default'     => config('auth.defaults.guard'),
        'api_guard_driver'  => config('auth.guards.api.driver'),
        'api_guard_provider'=> config('auth.guards.api.provider'),
        'jwt_ttl'           => config('jwt.ttl'),
    ]);
});



