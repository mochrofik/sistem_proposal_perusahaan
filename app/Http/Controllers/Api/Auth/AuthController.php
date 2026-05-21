<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService
    ) {}

    /**
     * Authenticate the user and return a Sanctum Bearer token.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->loginApi(
            credentials: $request->only('email', 'password'),
            deviceName:  $request->input('device_name', $request->userAgent() ?? 'api-token'),
        );

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil.',
            'data'    => [
                'token'      => $result['token'],
                'token_type' => 'Bearer',
                'user'       => [
                    'id'    => $result['user']->id,
                    'name'  => $result['user']->name,
                    'email' => $result['user']->email,
                ],
            ],
        ], 200);
    }

  
    public function logout(Request $request): JsonResponse
    {
        $this->authService->logoutApi($request->user());

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil. Token telah dicabut.',
        ], 200);
    }

    /**
     *
     * Return the currently authenticated user's profile.
     * Requires: Authorization: Bearer <token>
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'data'    => [
                'id'         => $user->id,
                'name'       => $user->name,
                'email'      => $user->email,
                'roles'      => $user->getRoleNames(),
                'created_at' => $user->created_at?->toDateTimeString(),
            ],
        ], 200);
    }
}
