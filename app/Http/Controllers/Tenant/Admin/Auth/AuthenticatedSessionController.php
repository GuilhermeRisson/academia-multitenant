<?php

namespace App\Http\Controllers\Tenant\Admin;

use App\Http\Controllers\Controller;
use App\Services\Tenant\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

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
        return Inertia::render('Admin/Auth/Login');
    }

    /**
     * Processar login.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authService->login($request->only('email', 'password'), $request->boolean('remember'));

        return redirect()->intended(route('admin.dashboard'));
    }

    /**
     * Processar logout.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $this->authService->logout();

        return redirect()->route('admin.login');
    }
}
