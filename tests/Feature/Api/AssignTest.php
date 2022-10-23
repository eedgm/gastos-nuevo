<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Assign;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssignTest extends TestCase
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
    public function it_gets_assigns_list()
    {
        $assigns = Assign::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.assigns.index'));

        $response->assertOk()->assertSee($assigns[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_assign()
    {
        $data = Assign::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.assigns.store'), $data);

        $this->assertDatabaseHas('assigns', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_assign()
    {
        $assign = Assign::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence(15),
        ];

        $response = $this->putJson(route('api.assigns.update', $assign), $data);

        $data['id'] = $assign->id;

        $this->assertDatabaseHas('assigns', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_assign()
    {
        $assign = Assign::factory()->create();

        $response = $this->deleteJson(route('api.assigns.destroy', $assign));

        $this->assertSoftDeleted($assign);

        $response->assertNoContent();
    }
}
