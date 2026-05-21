<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{
    // =========================================================================
    // WEB (Session-based)
    // =========================================================================

    /**
     * Authenticate user via session (Web).
     *
     * @param  array{email: string, password: string}  $credentials
     * @param  bool  $remember
     * @return User
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function loginWeb(array $credentials, bool $remember = false): User
    {
        if (! Auth::attempt($credentials, $remember)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password yang Anda masukkan salah.'],
            ]);
        }

        /** @var User $user */
        $user = Auth::user();

        return $user;
    }

    /**
     * Logout user from web session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function logoutWeb(\Illuminate\Http\Request $request): void
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    // =========================================================================
    // API (Token-based — Laravel Sanctum)
    // =========================================================================

    /**
     * Authenticate user and issue a Sanctum personal access token (API).
     *
     * @param  array{email: string, password: string}  $credentials
     * @param  string  $deviceName  Label for the token (browser / device name)
     * @return array{token: string, user: User}
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function loginApi(array $credentials, string $deviceName = 'api-token'): array
    {
        if (! Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password yang Anda masukkan salah.'],
            ]);
        }

        /** @var User $user */
        $user = Auth::user();

        // Revoke all previous tokens so only one active session exists
        $user->tokens()->delete();

        $token = $user->createToken($deviceName)->plainTextToken;

        return [
            'token' => $token,
            'user'  => $user,
        ];
    }

    /**
     * Revoke the current Sanctum token (API logout).
     *
     * @param  User  $user
     * @return void
     */
    public function logoutApi(User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}
