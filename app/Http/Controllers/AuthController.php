<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthForgotPasswordRequest;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Http\Requests\AuthResetPasswordRequest;
use App\Http\Requests\AuthVerifyEmailRequest;
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

    public function verifyEmail (AuthVerifyEmailRequest $request)
    {
        $validated = $request->validated();

        $user = $this->authService->verifyEmail($validated['token']);

        return new UserResource($user);
    }

    public function forgotPassword(AuthForgotPasswordRequest $request)
    {
        $validated = $request->validated();

        return $this->authService->forgotPassword($validated['email']);
    }

    public function resetPassword(AuthResetPasswordRequest $request)
    {
        $validated = $request->validated();

        return $this->authService->resetPassword($validated['email'], $validated['password'], $validated['token']);
    }
}
