<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Executed;

use App\Models\Type;
use App\Models\Expense;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExecutedControllerTest extends TestCase
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
    public function it_displays_index_view_with_executeds()
    {
        $executeds = Executed::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('executeds.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.executeds.index')
            ->assertViewHas('executeds');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_executed()
    {
        $response = $this->get(route('executeds.create'));

        $response->assertOk()->assertViewIs('app.executeds.create');
    }

    /**
     * @test
     */
    public function it_stores_the_executed()
    {
        $data = Executed::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('executeds.store'), $data);

        $this->assertDatabaseHas('executeds', $data);

        $executed = Executed::latest('id')->first();

        $response->assertRedirect(route('executeds.edit', $executed));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_executed()
    {
        $executed = Executed::factory()->create();

        $response = $this->get(route('executeds.show', $executed));

        $response
            ->assertOk()
            ->assertViewIs('app.executeds.show')
            ->assertViewHas('executed');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_executed()
    {
        $executed = Executed::factory()->create();

        $response = $this->get(route('executeds.edit', $executed));

        $response
            ->assertOk()
            ->assertViewIs('app.executeds.edit')
            ->assertViewHas('executed');
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

        $response = $this->put(route('executeds.update', $executed), $data);

        $data['id'] = $executed->id;

        $this->assertDatabaseHas('executeds', $data);

        $response->assertRedirect(route('executeds.edit', $executed));
    }

    /**
     * @test
     */
    public function it_deletes_the_executed()
    {
        $executed = Executed::factory()->create();

        $response = $this->delete(route('executeds.destroy', $executed));

        $response->assertRedirect(route('executeds.index'));

        $this->assertSoftDeleted($executed);
    }
}
