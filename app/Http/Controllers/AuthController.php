<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller{
// {
//     public function login(Request $request)
//     {
//         $credentials = $request->validate([
//             'email'    => 'required|email',
//             'password' => 'required',
//         ]);

//         // IMPORTANT: use the JWT guard
//         if (!$token = auth('api')->attempt($credentials)) {
//             return response()->json(['error' => 'Invalid credentials'], 401);
//         }

//         return response()->json([
//             'access_token' => $token,
//             'token_type'   => 'bearer',
//             'expires_in'   => auth('api')->factory()->getTTL() * 60,
//             'user'         => auth('api')->user(),
//         ]);
//     }

//     public function logout()
//     {
//         auth('api')->logout();
//         return response()->json(['message' => 'Successfully logged out']);
//     }

//     public function me()
//     {
//         return response()->json(auth('api')->user());
//     }
use Tymon\JWTAuth\Exceptions\JWTException;

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

    try {
        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    } catch (JWTException $e) {
        // TEMP: reveal the exact server error so we can fix quickly
        return response()->json(['error' => 'JWT error', 'detail' => $e->getMessage()], 500);
    }

    return response()->json([
        'access_token' => $token,
        'token_type'   => 'bearer',
        'expires_in'   => auth('api')->factory()->getTTL() * 60,
        'user'         => auth('api')->user(),
    ]);
}
}