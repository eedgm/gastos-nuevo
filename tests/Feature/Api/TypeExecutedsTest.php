<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Type;
use App\Models\Executed;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TypeExecutedsTest extends TestCase
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
    public function it_gets_type_executeds()
    {
        $type = Type::factory()->create();
        $executeds = Executed::factory()
            ->count(2)
            ->create([
                'type_id' => $type->id,
            ]);

        $response = $this->getJson(route('api.types.executeds.index', $type));

        $response->assertOk()->assertSee($executeds[0]->description);
    }

    /**
     * @test
     */
    public function it_stores_the_type_executeds()
    {
        $type = Type::factory()->create();
        $data = Executed::factory()
            ->make([
                'type_id' => $type->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.types.executeds.store', $type),
            $data
        );

        $this->assertDatabaseHas('executeds', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $executed = Executed::latest('id')->first();

        $this->assertEquals($type->id, $executed->type_id);
    }
}
