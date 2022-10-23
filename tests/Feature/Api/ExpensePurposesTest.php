<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Expense;
use App\Models\Purpose;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExpensePurposesTest extends TestCase
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
    public function it_gets_expense_purposes()
    {
        $expense = Expense::factory()->create();
        $purpose = Purpose::factory()->create();

        $expense->purposes()->attach($purpose);

        $response = $this->getJson(
            route('api.expenses.purposes.index', $expense)
        );

        $response->assertOk()->assertSee($purpose->name);
    }

    /**
     * @test
     */
    public function it_can_attach_purposes_to_expense()
    {
        $expense = Expense::factory()->create();
        $purpose = Purpose::factory()->create();

        $response = $this->postJson(
            route('api.expenses.purposes.store', [$expense, $purpose])
        );

        $response->assertNoContent();

        $this->assertTrue(
            $expense
                ->purposes()
                ->where('purposes.id', $purpose->id)
                ->exists()
        );
    }

    /**
     * @test
     */
    public function it_can_detach_purposes_from_expense()
    {
        $expense = Expense::factory()->create();
        $purpose = Purpose::factory()->create();

        $response = $this->deleteJson(
            route('api.expenses.purposes.store', [$expense, $purpose])
        );

        $response->assertNoContent();

        $this->assertFalse(
            $expense
                ->purposes()
                ->where('purposes.id', $purpose->id)
                ->exists()
        );
    }
}
