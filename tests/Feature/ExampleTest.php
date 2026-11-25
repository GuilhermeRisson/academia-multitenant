<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_central_landing_page_returns_a_successful_response(): void
    {
        $this->withoutVite();

        // As rotas centrais só respondem no domínio central, não em localhost.
        $response = $this->get('http://academia-multitenant.test/');

        $response->assertStatus(200);
    }

    public function test_authenticated_admin_can_open_profile_page(): void
    {
        $this->withoutVite();

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('http://academia-multitenant.test/profile');

        $response->assertOk();
    }
}
