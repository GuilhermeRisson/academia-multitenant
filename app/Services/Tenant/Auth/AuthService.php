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
        if (Auth::guard('tenant')->attempt($credentials, $remember)) {
            session()->regenerate();

            // Captura o tenant atual (assegure que isso funciona no contexto)
            $tenant = app(\Stancl\Tenancy\Tenancy::class)->tenant;

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
        Auth::guard('tenant')->logout();

        session()->invalidate();
        session()->regenerateToken();
    }
}
