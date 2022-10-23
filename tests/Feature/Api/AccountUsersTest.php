<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Account;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountUsersTest extends TestCase
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
    public function it_gets_account_users()
    {
        $account = Account::factory()->create();
        $user = User::factory()->create();

        $account->users()->attach($user);

        $response = $this->getJson(route('api.accounts.users.index', $account));

        $response->assertOk()->assertSee($user->name);
    }

    /**
     * @test
     */
    public function it_can_attach_users_to_account()
    {
        $account = Account::factory()->create();
        $user = User::factory()->create();

        $response = $this->postJson(
            route('api.accounts.users.store', [$account, $user])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $account
                ->users()
                ->where('users.id', $user->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_users_from_account()
    {
        $account = Account::factory()->create();
        $user = User::factory()->create();

        $response = $this->deleteJson(
            route('api.accounts.users.store', [$account, $user])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $account
                ->users()
                ->where('users.id', $user->id)
                ->exists()
        );
    }
}
