<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Color;
use App\Models\Purpose;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ColorPurposesTest extends TestCase
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
    public function it_gets_color_purposes()
    {
        $color = Color::factory()->create();
        $purposes = Purpose::factory()
            ->count(2)
            ->create([
                'color_id' => $color->id,
            ]);

        $response = $this->getJson(route('api.colors.purposes.index', $color));

        $response->assertOk()->assertSee($purposes[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_color_purposes()
    {
        $color = Color::factory()->create();
        $data = Purpose::factory()
            ->make([
                'color_id' => $color->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.colors.purposes.store', $color),
            $data
        );

        $this->assertDatabaseHas('purposes', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $purpose = Purpose::latest('id')->first();

        $this->assertEquals($color->id, $purpose->color_id);
    }
}
