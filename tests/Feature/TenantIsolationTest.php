<?php

namespace Tests\Feature;

use App\Models\Central\Tenant;
use App\Models\Tenant\Member;
use App\Models\Tenant\Plan;
use App\Models\Tenant\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * Garante que uma academia (tenant) nunca enxerga nem acessa os dados de outra.
 */
class TenantIsolationTest extends TestCase
{
    use RefreshDatabase;

    private Tenant $academiaA;
    private Tenant $academiaB;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();

        $this->academiaA = $this->createTenant('academiaa', '11111111000111');
        $this->academiaB = $this->createTenant('academiab', '22222222000122');
    }

    protected function tearDown(): void
    {
        tenancy()->end();

        // Dispara o evento TenantDeleted, que apaga o banco de cada academia.
        $this->academiaA->delete();
        $this->academiaB->delete();

        parent::tearDown();
    }

    public function test_each_tenant_has_its_own_database(): void
    {
        $this->assertNotSame(
            $this->academiaA->database()->getName(),
            $this->academiaB->database()->getName(),
        );
    }

    public function test_members_and_plans_from_one_tenant_are_not_visible_to_another(): void
    {
        $this->academiaA->run(function () {
            $plan = Plan::create(['name' => 'Mensal', 'price' => 99.90]);
            Member::create(['name' => 'Aluno da A', 'email' => 'aluno@a.com', 'plan_id' => $plan->id]);
        });

        $this->academiaA->run(function () {
            $this->assertSame(1, Plan::count());
            $this->assertSame(1, Member::count());
        });

        $this->academiaB->run(function () {
            $this->assertSame(0, Plan::count());
            $this->assertSame(0, Member::count());
            $this->assertNull(Member::where('email', 'aluno@a.com')->first());
        });
    }

    public function test_same_email_can_exist_independently_in_each_tenant(): void
    {
        $this->academiaA->run(fn () => Member::create(['name' => 'Aluno A', 'email' => 'mesmo@email.com']));
        $this->academiaB->run(fn () => Member::create(['name' => 'Aluno B', 'email' => 'mesmo@email.com']));

        $this->academiaA->run(fn () => $this->assertSame('Aluno A', Member::where('email', 'mesmo@email.com')->value('name')));
        $this->academiaB->run(fn () => $this->assertSame('Aluno B', Member::where('email', 'mesmo@email.com')->value('name')));
    }

    public function test_admin_of_one_tenant_cannot_log_in_to_another(): void
    {
        $this->academiaA->run(fn () => User::create([
            'email' => 'admin@a.com',
            'password' => Hash::make('senha-da-a'),
        ]));

        $this->post($this->tenantUrl('academiab', '/admin/login'), [
            'email' => 'admin@a.com',
            'password' => 'senha-da-a',
        ]);

        $this->assertGuest('tenant');
    }

    public function test_admin_of_one_tenant_can_log_in_to_its_own(): void
    {
        $this->academiaA->run(fn () => User::create([
            'email' => 'admin@a.com',
            'password' => Hash::make('senha-da-a'),
        ]));

        $this->post($this->tenantUrl('academiaa', '/admin/login'), [
            'email' => 'admin@a.com',
            'password' => 'senha-da-a',
        ]);

        $this->assertAuthenticated('tenant');
    }

    private function createTenant(string $subdomain, string $cnpj): Tenant
    {
        $tenant = Tenant::create([
            'name' => $subdomain,
            'email' => "{$subdomain}@example.com",
            'cnpj' => $cnpj,
            'street' => 'Rua Teste',
            'number' => '1',
            'city' => 'Muriaé',
            'state' => 'MG',
            'postal_code' => '36880-000',
        ]);

        $tenant->domains()->create(['domain' => "{$subdomain}.academia-multitenant.test"]);

        return $tenant;
    }

    private function tenantUrl(string $subdomain, string $path): string
    {
        return "http://{$subdomain}.academia-multitenant.test{$path}";
    }
}
