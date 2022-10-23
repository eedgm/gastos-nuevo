<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Cluster;
use App\Models\Expense;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClusterExpensesTest extends TestCase
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
    public function it_gets_cluster_expenses()
    {
        $cluster = Cluster::factory()->create();
        $expenses = Expense::factory()
            ->count(2)
            ->create([
                'cluster_id' => $cluster->id,
            ]);

        $response = $this->getJson(
            route('api.clusters.expenses.index', $cluster)
        );

        $response->assertOk()->assertSee($expenses[0]->date_to);
    }

    /**
     * @test
     */
    public function it_stores_the_cluster_expenses()
    {
        $cluster = Cluster::factory()->create();
        $data = Expense::factory()
            ->make([
                'cluster_id' => $cluster->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.clusters.expenses.store', $cluster),
            $data
        );

        $this->assertDatabaseHas('expenses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $expense = Expense::latest('id')->first();

        $this->assertEquals($cluster->id, $expense->cluster_id);
    }
}
