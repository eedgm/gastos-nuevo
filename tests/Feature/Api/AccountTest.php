<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Account;

use App\Models\Bank;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountTest extends TestCase
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
    public function it_gets_accounts_list()
    {
        $accounts = Account::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.accounts.index'));

        $response->assertOk()->assertSee($accounts[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_account()
    {
        $data = Account::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.accounts.store'), $data);

        $this->assertDatabaseHas('accounts', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_updates_the_account()
    {
        $account = Account::factory()->create();

        $bank = Bank::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence(15),
            'number' => $this->faker->text(255),
            'type' => 'Ahorro',
            'owner' => $this->faker->text(255),
            'bank_id' => $bank->id,
        ];

        $response = $this->putJson(
            route('api.accounts.update', $account),
            $data
        );

        $data['id'] = $account->id;

        $this->assertDatabaseHas('accounts', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_account()
    {
        $account = Account::factory()->create();

        $response = $this->deleteJson(route('api.accounts.destroy', $account));

        $this->assertSoftDeleted($account);

        $response->assertNoContent();
    }
}
