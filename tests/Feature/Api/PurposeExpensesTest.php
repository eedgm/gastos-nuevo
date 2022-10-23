<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Purpose;
use App\Models\Expense;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurposeExpensesTest extends TestCase
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
    public function it_gets_purpose_expenses()
    {
        $purpose = Purpose::factory()->create();
        $expense = Expense::factory()->create();

        $purpose->expenses()->attach($expense);

        $response = $this->getJson(
            route('api.purposes.expenses.index', $purpose)
        );

        $response->assertOk()->assertSee($expense->date_to);
    }

    /**
     * @test
     */
    public function it_can_attach_expenses_to_purpose()
    {
        $purpose = Purpose::factory()->create();
        $expense = Expense::factory()->create();

        $response = $this->postJson(
            route('api.purposes.expenses.store', [$purpose, $expense])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $purpose
                ->expenses()
                ->where('expenses.id', $expense->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_expenses_from_purpose()
    {
        $purpose = Purpose::factory()->create();
        $expense = Expense::factory()->create();

        $response = $this->deleteJson(
            route('api.purposes.expenses.store', [$purpose, $expense])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $purpose
                ->expenses()
                ->where('expenses.id', $expense->id)
                ->exists()
        );
    }
}
