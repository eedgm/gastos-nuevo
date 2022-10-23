<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Cluster;
use App\Models\Account;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClusterAccountsTest extends TestCase
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
    public function it_gets_cluster_accounts()
    {
        $cluster = Cluster::factory()->create();
        $account = Account::factory()->create();

        $cluster->accounts()->attach($account);

        $response = $this->getJson(
            route('api.clusters.accounts.index', $cluster)
        );

        $response->assertOk()->assertSee($account->name);
    }

    /**
     * @test
     */
    public function it_can_attach_accounts_to_cluster()
    {
        $cluster = Cluster::factory()->create();
        $account = Account::factory()->create();

        $response = $this->postJson(
            route('api.clusters.accounts.store', [$cluster, $account])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $cluster
                ->accounts()
                ->where('accounts.id', $account->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_accounts_from_cluster()
    {
        $cluster = Cluster::factory()->create();
        $account = Account::factory()->create();

        $response = $this->deleteJson(
            route('api.clusters.accounts.store', [$cluster, $account])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $cluster
                ->accounts()
                ->where('accounts.id', $account->id)
                ->exists()
        );
    }
}
