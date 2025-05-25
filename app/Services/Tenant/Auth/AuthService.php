<?php

namespace App\Services\Tenant\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\Tenant\User;

class AuthService
{
    /**
     * Realizar login.
     */
    public function login(array $credentials, bool $remember = false): void
    {
        $validated = validator($credentials, [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ])->validate();

        if (!Auth::attempt($validated, $remember)) {
            throw ValidationException::withMessages([
                'email' => 'As credenciais estão incorretas.',
            ]);
        }

        session()->regenerate();
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
