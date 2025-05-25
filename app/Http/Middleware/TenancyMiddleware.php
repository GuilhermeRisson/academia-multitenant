<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Central\Tenant;
use Stancl\Tenancy\Tenancy;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TenancyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Protege domínio principal
        $centralDomains = ['central.seudominio.com', 'localhost', '127.0.0.1'];
        if (in_array($request->getHost(), $centralDomains)) {
            return $next($request);
        }

        // Extrai subdomínio
        $hostParts = explode('.', $request->getHost());

        if (count($hostParts) < 3) {
            throw new NotFoundHttpException('Tenant inválido ou domínio mal formatado');
        }

        $tenantSubdomain = $hostParts[0];

        // Busca tenant
        $tenant = Tenant::where('name', $tenantSubdomain)->first();

        if (!$tenant) {
            throw new NotFoundHttpException('Tenant não encontrado');
        }

        // if (!$tenant->is_active) {
        //     return response()->view('errors.tenant-inactive', [], 403);
        // }

        // Inicializa tenancy
        app(Tenancy::class)->initialize($tenant);

        return $next($request);
    }
}
