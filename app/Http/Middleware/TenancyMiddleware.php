<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Central\Tenant;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TenancyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $tenantSubdomain = explode('.', $request->getHost())[0];

        // Busca tenant
        $tenant = Tenant::where('name', $tenantSubdomain)->first();

        // if (!$tenant) {
        //     // Se não existe, redireciona para uma página de erro
        //     return redirect()->route('tenant.notfound');
        // }

        // if (!$tenant->is_active) {
        //     // Se está desativado, redireciona para outra página
        //     return redirect()->route('tenant.inactive');
        // }

        // Se tudo ok, inicializa o tenant
        tenancy()->initialize($tenant);

        return $next($request);
    }
}
