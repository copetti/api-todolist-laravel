<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(AuthLoginRequest $request)
    {
        $validated = $request->validated();

        $token = $this->authService->login($validated['email'], $validated['password']);

        return (new UserResource(auth()->user()))->additional($token);
    }

    public function register(AuthRegisterRequest $request)
    {
        $validated = $request->validated();

        $user = $this->authService->register($validated['first_name'], $validated['last_name'] ?? '', $validated['email'], $validated['password']);

        return new UserResource($user);
    }
}
