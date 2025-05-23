<?php

// app/Http/Middleware/TenancyMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Tenant;

class TenancyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Extrai o tenant do subdomínio
        $tenantSubdomain = explode('.', $request->getHost())[0];
        
        // Busca o tenant no banco de dados
        $tenant = Tenant::where('subdomain', $tenantSubdomain)->firstOrFail();
        
        // Inicializa o tenant (você precisará implementar essa lógica)
        tenancy()->initialize($tenant);
        
        return $next($request);
    }
}