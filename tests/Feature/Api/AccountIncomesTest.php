<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Income;
use App\Models\Account;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountIncomesTest extends TestCase
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
    public function it_gets_account_incomes()
    {
        $account = Account::factory()->create();
        $incomes = Income::factory()
            ->count(2)
            ->create([
                'account_id' => $account->id,
            ]);

        $response = $this->getJson(
            route('api.accounts.incomes.index', $account)
        );

        $response->assertOk()->assertSee($incomes[0]->date);
    }

    /**
     * @test
     */
    public function it_stores_the_account_incomes()
    {
        $account = Account::factory()->create();
        $data = Income::factory()
            ->make([
                'account_id' => $account->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.accounts.incomes.store', $account),
            $data
        );

        $this->assertDatabaseHas('incomes', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $income = Income::latest('id')->first();

        $this->assertEquals($account->id, $income->account_id);
    }
}
