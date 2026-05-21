<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\WebLoginRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService
    ) {}

    /**
     * GET /login
     *
     * Show the login form.
     */
    public function showLogin(): View|RedirectResponse
    {
        // Already authenticated → go to dashboard
        if (auth()->check()) {
            return redirect()->route('web.dashboard');
        }

        return view('auth.login');
    }

    /**
     * POST /login
     *
     * Handle login form submission via session.
     */
    public function login(WebLoginRequest $request): RedirectResponse
    {
        $this->authService->loginWeb(
            credentials: $request->only('email', 'password'),
            remember:    $request->boolean('remember'),
        );

        $request->session()->regenerate();

        return redirect()->intended(route('web.dashboard'));
    }

    /**
     * POST /logout
     *
     * Destroy the session and redirect to login.
     */
    public function logout(Request $request): RedirectResponse
    {
        $this->authService->logoutWeb($request);

        return redirect()->route('web.login');
    }

    /**
     * GET /register
     * Show the registration form.
     */
    public function showRegister(): View|RedirectResponse
    {
        if (auth()->check()) {
            return redirect()->route('web.dashboard');
        }

        $roles = \Spatie\Permission\Models\Role::all();
        $divisions = \App\Models\Division::all();

        return view('auth.register', compact('roles', 'divisions'));
    }

    /**
     * POST /register
     * Handle registration.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
            'division_id' => 'required|exists:divisions,id',
        ]);

        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'division_id' => $validated['division_id'],
        ]);

        $user->assignRole($validated['role']);

        $this->authService->loginWeb(
            credentials: ['email' => $validated['email'], 'password' => $validated['password']],
            remember: false
        );

        $request->session()->regenerate();

        return redirect()->route('web.dashboard');
    }
}
