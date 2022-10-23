<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Type;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TypeControllerTest extends TestCase
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
    public function it_displays_index_view_with_types()
    {
        $types = Type::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('types.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.types.index')
            ->assertViewHas('types');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_type()
    {
        $response = $this->get(route('types.create'));

        $response->assertOk()->assertViewIs('app.types.create');
    }

    /**
     * @test
     */
    public function it_stores_the_type()
    {
        $data = Type::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('types.store'), $data);

        $this->assertDatabaseHas('types', $data);

        $type = Type::latest('id')->first();

        $response->assertRedirect(route('types.edit', $type));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_type()
    {
        $type = Type::factory()->create();

        $response = $this->get(route('types.show', $type));

        $response
            ->assertOk()
            ->assertViewIs('app.types.show')
            ->assertViewHas('type');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_type()
    {
        $type = Type::factory()->create();

        $response = $this->get(route('types.edit', $type));

        $response
            ->assertOk()
            ->assertViewIs('app.types.edit')
            ->assertViewHas('type');
    }

    /**
     * @test
     */
    public function it_updates_the_type()
    {
        $type = Type::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence(15),
        ];

        $response = $this->put(route('types.update', $type), $data);

        $data['id'] = $type->id;

        $this->assertDatabaseHas('types', $data);

        $response->assertRedirect(route('types.edit', $type));
    }

    /**
     * @test
     */
    public function it_deletes_the_type()
    {
        $type = Type::factory()->create();

        $response = $this->delete(route('types.destroy', $type));

        $response->assertRedirect(route('types.index'));

        $this->assertSoftDeleted($type);
    }
}
