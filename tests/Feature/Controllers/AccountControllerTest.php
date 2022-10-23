<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Account;

use App\Models\Bank;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccountControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(
            User::factory()->create(['email' => 'admin@admin.com'])
        );

        $this->seed(\Database\Seeders\PermissionsSeeder::class);

        $this->withoutExceptionHandling();
    }

    /**
     * @test
     */
    public function it_displays_index_view_with_accounts()
    {
        $accounts = Account::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('accounts.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.accounts.index')
            ->assertViewHas('accounts');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_account()
    {
        $response = $this->get(route('accounts.create'));

        $response->assertOk()->assertViewIs('app.accounts.create');
    }

    /**
     * @test
     */
    public function it_stores_the_account()
    {
        $data = Account::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('accounts.store'), $data);

        $this->assertDatabaseHas('accounts', $data);

        $account = Account::latest('id')->first();

        $response->assertRedirect(route('accounts.edit', $account));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_account()
    {
        $account = Account::factory()->create();

        $response = $this->get(route('accounts.show', $account));

        $response
            ->assertOk()
            ->assertViewIs('app.accounts.show')
            ->assertViewHas('account');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_account()
    {
        $account = Account::factory()->create();

        $response = $this->get(route('accounts.edit', $account));

        $response
            ->assertOk()
            ->assertViewIs('app.accounts.edit')
            ->assertViewHas('account');
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

        $response = $this->put(route('accounts.update', $account), $data);

        $data['id'] = $account->id;

        $this->assertDatabaseHas('accounts', $data);

        $response->assertRedirect(route('accounts.edit', $account));
    }

    /**
     * @test
     */
    public function it_deletes_the_account()
    {
        $account = Account::factory()->create();

        $response = $this->delete(route('accounts.destroy', $account));

        $response->assertRedirect(route('accounts.index'));

        $this->assertSoftDeleted($account);
    }
}
