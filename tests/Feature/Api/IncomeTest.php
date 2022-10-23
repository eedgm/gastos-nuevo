<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Income;

use App\Models\Account;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IncomeTest extends TestCase
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
    public function it_gets_incomes_list()
    {
        $incomes = Income::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.incomes.index'));

        $response->assertOk()->assertSee($incomes[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_income()
    {
        $data = Income::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.incomes.store'), $data);

        $this->assertDatabaseHas('incomes', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_income()
    {
        $income = Income::factory()->create();

        $account = Account::factory()->create();

        $data = [
            'date' => $this->faker->date,
            'cost' => $this->faker->randomNumber(2),
            'description' => $this->faker->sentence(15),
            'account_id' => $account->id,
        ];

        $response = $this->putJson(route('api.incomes.update', $income), $data);

        $data['id'] = $income->id;

        $this->assertDatabaseHas('incomes', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_income()
    {
        $income = Income::factory()->create();

        $response = $this->deleteJson(route('api.incomes.destroy', $income));

        $this->assertSoftDeleted($income);

        $response->assertNoContent();
    }
}
