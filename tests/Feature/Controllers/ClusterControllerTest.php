<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Cluster;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClusterControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_clusters()
    {
        $clusters = Cluster::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('clusters.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.clusters.index')
            ->assertViewHas('clusters');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_cluster()
    {
        $response = $this->get(route('clusters.create'));

        $response->assertOk()->assertViewIs('app.clusters.create');
    }

    /**
     * @test
     */
    public function it_stores_the_cluster()
    {
        $data = Cluster::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('clusters.store'), $data);

        $this->assertDatabaseHas('clusters', $data);

        $cluster = Cluster::latest('id')->first();

        $response->assertRedirect(route('clusters.edit', $cluster));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_cluster()
    {
        $cluster = Cluster::factory()->create();

        $response = $this->get(route('clusters.show', $cluster));

        $response
            ->assertOk()
            ->assertViewIs('app.clusters.show')
            ->assertViewHas('cluster');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_cluster()
    {
        $cluster = Cluster::factory()->create();

        $response = $this->get(route('clusters.edit', $cluster));

        $response
            ->assertOk()
            ->assertViewIs('app.clusters.edit')
            ->assertViewHas('cluster');
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

        $response = $this->put(route('clusters.update', $cluster), $data);

        $data['id'] = $cluster->id;

        $this->assertDatabaseHas('clusters', $data);

        $response->assertRedirect(route('clusters.edit', $cluster));
    }

    /**
     * @test
     */
    public function it_deletes_the_cluster()
    {
        $cluster = Cluster::factory()->create();

        $response = $this->delete(route('clusters.destroy', $cluster));

        $response->assertRedirect(route('clusters.index'));

        $this->assertSoftDeleted($cluster);
    }
}
