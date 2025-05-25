<?php

namespace App\Services\Tenant\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Realizar login.
     */
    public function login(array $credentials, bool $remember = false): bool
    {
        if (Auth::attempt($credentials, $remember)) {
            // Garante que o redirecionamento mantenha o subdomínio
            $tenant = Tenant::current();
            if ($tenant) {
                session(['tenant_domain' => $tenant->domain]);
            }
            return true;
        }
        return false;
    }

    /**
     * Realizar logout.
     */
    public function logout(): void
    {
        Auth::logout();

        session()->invalidate();
        session()->regenerateToken();
    }
}
