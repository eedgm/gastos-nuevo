<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Account;
use App\Models\Expense;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountExpensesTest extends TestCase
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
    public function it_gets_account_expenses()
    {
        $account = Account::factory()->create();
        $expenses = Expense::factory()
            ->count(2)
            ->create([
                'account_id' => $account->id,
            ]);

        $response = $this->getJson(
            route('api.accounts.expenses.index', $account)
        );

        $response->assertOk()->assertSee($expenses[0]->date_to);
    }

    /**
     * @test
     */
    public function it_stores_the_account_expenses()
    {
        $account = Account::factory()->create();
        $data = Expense::factory()
            ->make([
                'account_id' => $account->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.accounts.expenses.store', $account),
            $data
        );

        $this->assertDatabaseHas('expenses', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $expense = Expense::latest('id')->first();

        $this->assertEquals($account->id, $expense->account_id);
    }
}
