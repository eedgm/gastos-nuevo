<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Expense;

use App\Models\Assign;
use App\Models\Cluster;
use App\Models\Account;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExpenseTest extends TestCase
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
    public function it_gets_expenses_list()
    {
        $expenses = Expense::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.expenses.index'));

        $response->assertOk()->assertSee($expenses[0]->date_to);
    }

    /**
     * @test
     */
    public function it_stores_the_expense()
    {
        $data = Expense::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.expenses.store'), $data);

        $this->assertDatabaseHas('expenses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_expense()
    {
        $expense = Expense::factory()->create();

        $cluster = Cluster::factory()->create();
        $assign = Assign::factory()->create();
        $account = Account::factory()->create();

        $data = [
            'date' => $this->faker->dateTime,
            'date_to' => $this->faker->date,
            'description' => $this->faker->sentence(15),
            'budget' => $this->faker->randomNumber(2),
            'cluster_id' => $cluster->id,
            'assign_id' => $assign->id,
            'account_id' => $account->id,
        ];

        $response = $this->putJson(
            route('api.expenses.update', $expense),
            $data
        );

        $data['id'] = $expense->id;

        $this->assertDatabaseHas('expenses', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_expense()
    {
        $expense = Expense::factory()->create();

        $response = $this->deleteJson(route('api.expenses.destroy', $expense));

        $this->assertSoftDeleted($expense);

        $response->assertNoContent();
    }
}
