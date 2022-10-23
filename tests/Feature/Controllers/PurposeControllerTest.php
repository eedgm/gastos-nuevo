<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Purpose;

use App\Models\Color;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurposeControllerTest extends TestCase
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
    public function it_displays_index_view_with_purposes()
    {
        $purposes = Purpose::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('purposes.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.purposes.index')
            ->assertViewHas('purposes');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_purpose()
    {
        $response = $this->get(route('purposes.create'));

        $response->assertOk()->assertViewIs('app.purposes.create');
    }

    /**
     * @test
     */
    public function it_stores_the_purpose()
    {
        $data = Purpose::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('purposes.store'), $data);

        $this->assertDatabaseHas('purposes', $data);

        $purpose = Purpose::latest('id')->first();

        $response->assertRedirect(route('purposes.edit', $purpose));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_purpose()
    {
        $purpose = Purpose::factory()->create();

        $response = $this->get(route('purposes.show', $purpose));

        $response
            ->assertOk()
            ->assertViewIs('app.purposes.show')
            ->assertViewHas('purpose');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_purpose()
    {
        $purpose = Purpose::factory()->create();

        $response = $this->get(route('purposes.edit', $purpose));

        $response
            ->assertOk()
            ->assertViewIs('app.purposes.edit')
            ->assertViewHas('purpose');
    }

    /**
     * @test
     */
    public function it_updates_the_purpose()
    {
        $purpose = Purpose::factory()->create();

        $color = Color::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'code' => $this->faker->word(255),
            'color_id' => $color->id,
        ];

        $response = $this->put(route('purposes.update', $purpose), $data);

        $data['id'] = $purpose->id;

        $this->assertDatabaseHas('purposes', $data);

        $response->assertRedirect(route('purposes.edit', $purpose));
    }

    /**
     * @test
     */
    public function it_deletes_the_purpose()
    {
        $purpose = Purpose::factory()->create();

        $response = $this->delete(route('purposes.destroy', $purpose));

        $response->assertRedirect(route('purposes.index'));

        $this->assertSoftDeleted($purpose);
    }
}
