<?php

// use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogApiController;
use App\Http\Controllers\BlogController;


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

// turn on nanti
// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\AuthController;
// use App\Http\Controllers\BlogApiController; // we'll use ONE controller

// ---------- Public (no auth) ----------

// IMPORTANT:
// - Do NOT define Route::apiResource('blogs', ...) elsewhere.
// - Do NOT re-declare GET /blogs or GET /blogs/{id} inside the auth group.
// - Temporarily STOP using BlogController entirely.

// turn on nanti

// Route::middleware('jwt.auth')->group(function () {
//   Route::post('/blogs',        [BlogApiController::class, 'store']);
//   Route::put('/blogs/{id}',    [BlogApiController::class, 'update']);
//   Route::delete('/blogs/{id}', [BlogApiController::class, 'destroy']);
//   Route::post('/logout', [AuthController::class, 'logout']);
//   Route::get('/me',      [AuthController::class, 'me']);
// });


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

Route::post('/login', [AuthController::class, 'login']);

Route::get('/blogs',      [BlogApiController::class, 'index']);  // list for users
Route::get('/blogs/{id}', [BlogApiController::class, 'show']);   // detail for users

Route::middleware(['jwt.auth'])->group(function () {
    Route::post('/blogs',        [BlogApiController::class, 'store']);
    Route::put('/blogs/{id}',    [BlogApiController::class, 'update']);
    Route::delete('/blogs/{id}', [BlogApiController::class, 'destroy']);

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me',      [AuthController::class, 'me']);
});

/**
 * Quick check: are we hitting the right DB? does the hash match? does JWT attempt succeed?
 */
Route::post('/_debug/login-check', function (Request $req) {
    $email = $req->string('email');
    $password = $req->string('password');

    $user = User::where('email', $email)->first();

    return response()->json([
        'db_connection'   => config('database.default'),
        'db_host'         => config('database.connections.'.config('database.default').'.host'),
        'user_found'      => (bool) $user,
        'hash_matches'    => $user ? Hash::check($password, $user->password) : false,
        'guard'           => config('auth.defaults.guard'),
        'attempt_result'  => Auth::guard('api')->attempt(['email'=>$email,'password'=>$password]) ? 'ok' : 'fail',
    ]);
});

/**
 * Force-create or update the admin with a known password (hashes server-side).
 * Call once in each environment, then remove.
 */
Route::post('/_admin/upsert', function (Request $req) {
    $data = $req->validate([
        'email'    => ['required','email'],
        'password' => ['required','string','min:6'],
        'name'     => ['nullable','string','max:100'],
        'role'     => ['nullable','string','max:50'],
    ]);

    // IMPORTANT: If you have a User::setPasswordAttribute mutator that hashes automatically,
    // then do NOT Hash::make() here to avoid double-hashing. Otherwise keep Hash::make.
    $user = User::updateOrCreate(
        ['email' => $data['email']],
        [
            'name'     => $data['name'] ?? 'Admin',
            'password' => Hash::make($data['password']),
            'role'     => $data['role'] ?? 'admin',
        ]
    );

    return response()->json([
        'message' => 'admin upserted',
        'user'    => ['id'=>$user->id, 'email'=>$user->email, 'name'=>$user->name, 'role'=>$user->role],
    ]);
});
