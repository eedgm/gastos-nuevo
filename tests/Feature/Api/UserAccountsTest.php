<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Account;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserAccountsTest extends TestCase
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
    public function it_gets_user_accounts()
    {
        $user = User::factory()->create();
        $account = Account::factory()->create();

        $user->accounts()->attach($account);

        $response = $this->getJson(route('api.users.accounts.index', $user));

        $response->assertOk()->assertSee($account->name);
    }

    /**
     * @test
     */
    public function it_can_attach_accounts_to_user()
    {
        $user = User::factory()->create();
        $account = Account::factory()->create();

        $response = $this->postJson(
            route('api.users.accounts.store', [$user, $account])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $user
                ->accounts()
                ->where('accounts.id', $account->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_accounts_from_user()
    {
        $user = User::factory()->create();
        $account = Account::factory()->create();

        $response = $this->deleteJson(
            route('api.users.accounts.store', [$user, $account])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $user
                ->accounts()
                ->where('accounts.id', $account->id)
                ->exists()
        );
    }
}
