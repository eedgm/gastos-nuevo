<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Assign;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssignControllerTest extends TestCase
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
    public function it_displays_index_view_with_assigns()
    {
        $assigns = Assign::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('assigns.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.assigns.index')
            ->assertViewHas('assigns');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_assign()
    {
        $response = $this->get(route('assigns.create'));

        $response->assertOk()->assertViewIs('app.assigns.create');
    }

    /**
     * @test
     */
    public function it_stores_the_assign()
    {
        $data = Assign::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('assigns.store'), $data);

        $this->assertDatabaseHas('assigns', $data);

        $assign = Assign::latest('id')->first();

        $response->assertRedirect(route('assigns.edit', $assign));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_assign()
    {
        $assign = Assign::factory()->create();

        $response = $this->get(route('assigns.show', $assign));

        $response
            ->assertOk()
            ->assertViewIs('app.assigns.show')
            ->assertViewHas('assign');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_assign()
    {
        $assign = Assign::factory()->create();

        $response = $this->get(route('assigns.edit', $assign));

        $response
            ->assertOk()
            ->assertViewIs('app.assigns.edit')
            ->assertViewHas('assign');
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

        $response = $this->put(route('assigns.update', $assign), $data);

        $data['id'] = $assign->id;

        $this->assertDatabaseHas('assigns', $data);

        $response->assertRedirect(route('assigns.edit', $assign));
    }

    /**
     * @test
     */
    public function it_deletes_the_assign()
    {
        $assign = Assign::factory()->create();

        $response = $this->delete(route('assigns.destroy', $assign));

        $response->assertRedirect(route('assigns.index'));

        $this->assertSoftDeleted($assign);
    }
}
