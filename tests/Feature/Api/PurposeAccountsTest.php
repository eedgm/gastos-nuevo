<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Purpose;
use App\Models\Account;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurposeAccountsTest extends TestCase
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
    public function it_gets_purpose_accounts()
    {
        $purpose = Purpose::factory()->create();
        $account = Account::factory()->create();

        $purpose->accounts()->attach($account);

        $response = $this->getJson(
            route('api.purposes.accounts.index', $purpose)
        );

        $response->assertOk()->assertSee($account->name);
    }

    /**
     * @test
     */
    public function it_can_attach_accounts_to_purpose()
    {
        $purpose = Purpose::factory()->create();
        $account = Account::factory()->create();

        $response = $this->postJson(
            route('api.purposes.accounts.store', [$purpose, $account])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $purpose
                ->accounts()
                ->where('accounts.id', $account->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_accounts_from_purpose()
    {
        $purpose = Purpose::factory()->create();
        $account = Account::factory()->create();

        $response = $this->deleteJson(
            route('api.purposes.accounts.store', [$purpose, $account])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $purpose
                ->accounts()
                ->where('accounts.id', $account->id)
                ->exists()
        );
    }
}
