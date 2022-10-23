<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Account;
use App\Models\Cluster;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountClustersTest extends TestCase
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
    public function it_gets_account_clusters()
    {
        $account = Account::factory()->create();
        $cluster = Cluster::factory()->create();

        $account->clusters()->attach($cluster);

        $response = $this->getJson(
            route('api.accounts.clusters.index', $account)
        );

        $response->assertOk()->assertSee($cluster->name);
    }

    /**
     * @test
     */
    public function it_can_attach_clusters_to_account()
    {
        $account = Account::factory()->create();
        $cluster = Cluster::factory()->create();

        $response = $this->postJson(
            route('api.accounts.clusters.store', [$account, $cluster])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $account
                ->clusters()
                ->where('clusters.id', $cluster->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_clusters_from_account()
    {
        $account = Account::factory()->create();
        $cluster = Cluster::factory()->create();

        $response = $this->deleteJson(
            route('api.accounts.clusters.store', [$account, $cluster])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $account
                ->clusters()
                ->where('clusters.id', $cluster->id)
                ->exists()
        );
    }
}
