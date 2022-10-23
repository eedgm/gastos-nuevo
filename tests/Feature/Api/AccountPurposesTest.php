<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Account;
use App\Models\Purpose;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountPurposesTest extends TestCase
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
    public function it_gets_account_purposes()
    {
        $account = Account::factory()->create();
        $purpose = Purpose::factory()->create();

        $account->purposes()->attach($purpose);

        $response = $this->getJson(
            route('api.accounts.purposes.index', $account)
        );

        $response->assertOk()->assertSee($purpose->name);
    }

    /**
     * @test
     */
    public function it_can_attach_purposes_to_account()
    {
        $account = Account::factory()->create();
        $purpose = Purpose::factory()->create();

        $response = $this->postJson(
            route('api.accounts.purposes.store', [$account, $purpose])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $account
                ->purposes()
                ->where('purposes.id', $purpose->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_purposes_from_account()
    {
        $account = Account::factory()->create();
        $purpose = Purpose::factory()->create();

        $response = $this->deleteJson(
            route('api.accounts.purposes.store', [$account, $purpose])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $account
                ->purposes()
                ->where('purposes.id', $purpose->id)
                ->exists()
        );
    }
}
