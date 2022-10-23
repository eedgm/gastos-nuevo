<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Assign;
use App\Models\Account;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssignAccountsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create(['email' => 'admin@admin.com']);

        Sanctum::actingAs($user, [], 'web');

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_gets_assign_accounts()
    {
        $assign = Assign::factory()->create();
        $account = Account::factory()->create();

        $assign->accounts()->attach($account);

        $response = $this->getJson(
            route('api.assigns.accounts.index', $assign)
        );

        $response->assertOk()->assertSee($account->name);
    }

    /**
     * @test
     */
    public function it_can_attach_accounts_to_assign()
    {
        $assign = Assign::factory()->create();
        $account = Account::factory()->create();

        $response = $this->postJson(
            route('api.assigns.accounts.store', [$assign, $account])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $assign
                ->accounts()
                ->where('accounts.id', $account->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_accounts_from_assign()
    {
        $assign = Assign::factory()->create();
        $account = Account::factory()->create();

        $response = $this->deleteJson(
            route('api.assigns.accounts.store', [$assign, $account])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $assign
                ->accounts()
                ->where('accounts.id', $account->id)
                ->exists()
        );
    }
}
