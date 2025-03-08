<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginApiRequest;
use App\Http\Requests\Api\Auth\RegisterApiRequest;
use App\Services\Api\AuthApiService;
use Illuminate\Http\JsonResponse;

class AuthApiController extends Controller
{
    public function __construct(public readonly AuthApiService $authApiService) {}

    public function register(RegisterApiRequest $request): JsonResponse
    {
        return $this->authApiService->register(validatedData: $request->validated());
    }

    public function login(LoginApiRequest $request): JsonResponse
    {
        return $this->authApiService->login(credentials: $request->only('email', 'password'));
    }

    public function logout(): JsonResponse
    {
        return $this->authApiService->logout();
    }
}
