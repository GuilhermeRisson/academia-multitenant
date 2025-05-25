<?php

namespace App\Http\Controllers\Tenant\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Services\Tenant\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Tenant\TenantDetail;

class AuthenticatedSessionController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Mostrar tela de login.
     */
    public function create(): Response
    {
        return Inertia::render('Gym/Auth/Login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if ($this->authService->login($credentials, $remember)) {
            return redirect()->to(url('admin/dashboard'));
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }


    public function destroy(Request $request): RedirectResponse
    {
        $this->authService->logout();

        return redirect()->route('admin.login');
    }
}
