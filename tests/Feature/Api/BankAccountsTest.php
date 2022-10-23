<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Bank;
use App\Models\Account;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BankAccountsTest extends TestCase
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
    public function it_gets_bank_accounts()
    {
        $bank = Bank::factory()->create();
        $accounts = Account::factory()
            ->count(2)
            ->create([
                'bank_id' => $bank->id,
            ]);

        $response = $this->getJson(route('api.banks.accounts.index', $bank));

        $response->assertOk()->assertSee($accounts[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_bank_accounts()
    {
        $bank = Bank::factory()->create();
        $data = Account::factory()
            ->make([
                'bank_id' => $bank->id,
            ])
            ->toArray();

        $response = $this->postJson(
            route('api.banks.accounts.store', $bank),
            $data
        );

        $this->assertDatabaseHas('accounts', $data);

        $response->assertStatus(201)->assertJsonFragment($data);

        $account = Account::latest('id')->first();

        $this->assertEquals($bank->id, $account->bank_id);
    }
}
