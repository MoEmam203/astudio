<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginApiRequest;
use App\Http\Requests\Api\Auth\RegisterApiRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AuthApiController extends Controller
{
    public function register(RegisterApiRequest $request): JsonResponse
    {
        $user =  User::create($request->validated());
        $token = $user->createToken('auth_token')->accessToken;

        return response()->json(data: [
            'status' => 1,
            'message' => 'User created successfully',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ]);
    }

    public function login(LoginApiRequest $request): JsonResponse 
    {
        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json(data: [
                'status' => 0,
                'message' => 'Invalid credentials',
                'data' => null
            ], status: 401);
        }

        $user = auth()->user();
        $token = $user->createToken('auth_token')->accessToken;

        return response()->json(data: [
            'status' => 1,
            'message' => 'User logged in successfully',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ]);
    }

    public function logout(): JsonResponse
    {
        auth()->user()->token()->revoke();

        return response()->json(data: [
            'status' => 1,
            'message' => 'User logged out successfully',
            'data' => null
        ]);
    }
}
