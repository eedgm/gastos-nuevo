<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Cluster;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClusterTest extends TestCase
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
    public function it_gets_clusters_list()
    {
        $clusters = Cluster::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.clusters.index'));

        $response->assertOk()->assertSee($clusters[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_cluster()
    {
        $data = Cluster::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.clusters.store'), $data);

        $this->assertDatabaseHas('clusters', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_cluster()
    {
        $cluster = Cluster::factory()->create();

        $data = [
            'name' => $this->faker->unique->name,
            'description' => $this->faker->sentence(15),
        ];

        $response = $this->putJson(
            route('api.clusters.update', $cluster),
            $data
        );

        $data['id'] = $cluster->id;

        $this->assertDatabaseHas('clusters', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_cluster()
    {
        $cluster = Cluster::factory()->create();

        $response = $this->deleteJson(route('api.clusters.destroy', $cluster));

        $this->assertSoftDeleted($cluster);

        $response->assertNoContent();
    }
}
