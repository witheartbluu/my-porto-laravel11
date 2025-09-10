<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $cred = $request->validate([
            'email'    => ['required','email'],
            'password' => ['required','string'],
        ]);

        try {
            if (!$token = Auth::guard('api')->attempt($cred)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            return response()->json([
                'access_token' => $token,
                'token_type'   => 'bearer',
                'expires_in'   => auth('api')->factory()->getTTL() * 60,
            ], 200);

        } catch (Throwable $e) {
            // Return a safe JSON error instead of a 500 HTML page
            return response()->json([
                'message' => 'Login failed',
                'hint'    => 'Check APP_KEY and JWT_SECRET env vars, and jwt-auth is installed',
            ], 500);
        }
    }

    public function me()
    {
        return response()->json(Auth::guard('api')->user());
    }

}

