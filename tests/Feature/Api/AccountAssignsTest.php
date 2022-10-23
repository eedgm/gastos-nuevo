<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Assign;
use App\Models\Account;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountAssignsTest extends TestCase
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
    public function it_gets_account_assigns()
    {
        $account = Account::factory()->create();
        $assign = Assign::factory()->create();

        $account->assigns()->attach($assign);

        $response = $this->getJson(
            route('api.accounts.assigns.index', $account)
        );

        $response->assertOk()->assertSee($assign->name);
    }

    /**
     * @test
     */
    public function it_can_attach_assigns_to_account()
    {
        $account = Account::factory()->create();
        $assign = Assign::factory()->create();

        $response = $this->postJson(
            route('api.accounts.assigns.store', [$account, $assign])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $account
                ->assigns()
                ->where('assigns.id', $assign->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_assigns_from_account()
    {
        $account = Account::factory()->create();
        $assign = Assign::factory()->create();

        $response = $this->deleteJson(
            route('api.accounts.assigns.store', [$account, $assign])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $account
                ->assigns()
                ->where('assigns.id', $assign->id)
                ->exists()
        );
    }
}
