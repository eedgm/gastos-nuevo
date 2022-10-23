<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Expense;
use App\Models\Executed;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExpenseExecutedsTest extends TestCase
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
    public function it_gets_expense_executeds()
    {
        $expense = Expense::factory()->create();
        $executeds = Executed::factory()
            ->count(2)
            ->create([
                'expense_id' => $expense->id,
            ]);

        $response = $this->getJson(
            route('api.expenses.executeds.index', $expense)
        );

        $response->assertOk()->assertSee($executeds[0]->description);
    }

    /**
     * @test
     */
    public function it_stores_the_expense_executeds()
    {
        $expense = Expense::factory()->create();
        $data = Executed::factory()
            ->make([
                'expense_id' => $expense->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.expenses.executeds.store', $expense),
            $data
        );

        $this->assertDatabaseHas('executeds', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $executed = Executed::latest('id')->first();

        $this->assertEquals($expense->id, $executed->expense_id);
    }
}
