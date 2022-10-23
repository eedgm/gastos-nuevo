<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Executed;

use App\Models\Type;
use App\Models\Expense;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExecutedTest extends TestCase
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
    public function it_gets_executeds_list()
    {
        $executeds = Executed::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.executeds.index'));

        $response->assertOk()->assertSee($executeds[0]->description);
    }

    /**
     * @test
     */
    public function it_stores_the_executed()
    {
        $data = Executed::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.executeds.store'), $data);

        $this->assertDatabaseHas('executeds', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_executed()
    {
        $executed = Executed::factory()->create();

        $expense = Expense::factory()->create();
        $type = Type::factory()->create();

        $data = [
            'cost' => $this->faker->randomNumber(2),
            'description' => $this->faker->sentence(15),
            'expense_id' => $expense->id,
            'type_id' => $type->id,
        ];

        $response = $this->putJson(
            route('api.executeds.update', $executed),
            $data
        );

        $data['id'] = $executed->id;

        $this->assertDatabaseHas('executeds', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_executed()
    {
        $executed = Executed::factory()->create();

        $response = $this->deleteJson(
            route('api.executeds.destroy', $executed)
        );

        $this->assertSoftDeleted($executed);

        $response->assertNoContent();
    }
}
