<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Purpose;

use App\Models\Color;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurposeTest extends TestCase
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
    public function it_gets_purposes_list()
    {
        $purposes = Purpose::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.purposes.index'));

        $response->assertOk()->assertSee($purposes[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_purpose()
    {
        $data = Purpose::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.purposes.store'), $data);

        $this->assertDatabaseHas('purposes', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(
            route('api.purposes.update', $purpose),
            $data
        );

        $data['id'] = $purpose->id;

        $this->assertDatabaseHas('purposes', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_purpose()
    {
        $purpose = Purpose::factory()->create();

        $response = $this->deleteJson(route('api.purposes.destroy', $purpose));

        $this->assertSoftDeleted($purpose);

        $response->assertNoContent();
    }
}
