<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Assign;
use App\Models\Expense;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssignExpensesTest extends TestCase
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
    public function it_gets_assign_expenses()
    {
        $assign = Assign::factory()->create();
        $expenses = Expense::factory()
            ->count(2)
            ->create([
                'assign_id' => $assign->id,
            ]);

        $response = $this->getJson(
            route('api.assigns.expenses.index', $assign)
        );

        $response->assertOk()->assertSee($expenses[0]->date_to);
    }

    /**
     * @test
     */
    public function it_stores_the_assign_expenses()
    {
        $assign = Assign::factory()->create();
        $data = Expense::factory()
            ->make([
                'assign_id' => $assign->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.assigns.expenses.store', $assign),
            $data
        );

        $this->assertDatabaseHas('expenses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $expense = Expense::latest('id')->first();

        $this->assertEquals($assign->id, $expense->assign_id);
    }
}
