<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Income;

use App\Models\Account;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IncomeControllerTest extends TestCase
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
    public function it_displays_index_view_with_incomes()
    {
        $incomes = Income::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('incomes.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.incomes.index')
            ->assertViewHas('incomes');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_income()
    {
        $response = $this->get(route('incomes.create'));

        $response->assertOk()->assertViewIs('app.incomes.create');
    }

    /**
     * @test
     */
    public function it_stores_the_income()
    {
        $data = Income::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('incomes.store'), $data);

        $this->assertDatabaseHas('incomes', $data);

        $income = Income::latest('id')->first();

        $response->assertRedirect(route('incomes.edit', $income));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_income()
    {
        $income = Income::factory()->create();

        $response = $this->get(route('incomes.show', $income));

        $response
            ->assertOk()
            ->assertViewIs('app.incomes.show')
            ->assertViewHas('income');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_income()
    {
        $income = Income::factory()->create();

        $response = $this->get(route('incomes.edit', $income));

        $response
            ->assertOk()
            ->assertViewIs('app.incomes.edit')
            ->assertViewHas('income');
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

        $response = $this->put(route('incomes.update', $income), $data);

        $data['id'] = $income->id;

        $this->assertDatabaseHas('incomes', $data);

        $response->assertRedirect(route('incomes.edit', $income));
    }

    /**
     * @test
     */
    public function it_deletes_the_income()
    {
        $income = Income::factory()->create();

        $response = $this->delete(route('incomes.destroy', $income));

        $response->assertRedirect(route('incomes.index'));

        $this->assertSoftDeleted($income);
    }
}
