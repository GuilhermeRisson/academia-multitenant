<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Tenant\HomeService;

class HomeController extends Controller
{
    protected HomeService $homeService;

    // Injeção correta via construtor
    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function index()
    {
        $data = $this->homeService->getTenantInfo(); // corrigido para $this->homeService
        return inertia('Gym/LandingPage', $data);
    }
}
