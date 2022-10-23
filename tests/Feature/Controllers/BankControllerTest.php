<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Bank;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BankControllerTest extends TestCase
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
    public function it_displays_index_view_with_banks()
    {
        $banks = Bank::factory()
            ->count(5)
            ->create();

        $response = $this->get(route('banks.index'));

        $response
            ->assertOk()
            ->assertViewIs('app.banks.index')
            ->assertViewHas('banks');
    }

    /**
     * @test
     */
    public function it_displays_create_view_for_bank()
    {
        $response = $this->get(route('banks.create'));

        $response->assertOk()->assertViewIs('app.banks.create');
    }

    /**
     * @test
     */
    public function it_stores_the_bank()
    {
        $data = Bank::factory()
            ->make()
            ->toArray();

        $response = $this->post(route('banks.store'), $data);

        $this->assertDatabaseHas('banks', $data);

        $bank = Bank::latest('id')->first();

        $response->assertRedirect(route('banks.edit', $bank));
    }

    /**
     * @test
     */
    public function it_displays_show_view_for_bank()
    {
        $bank = Bank::factory()->create();

        $response = $this->get(route('banks.show', $bank));

        $response
            ->assertOk()
            ->assertViewIs('app.banks.show')
            ->assertViewHas('bank');
    }

    /**
     * @test
     */
    public function it_displays_edit_view_for_bank()
    {
        $bank = Bank::factory()->create();

        $response = $this->get(route('banks.edit', $bank));

        $response
            ->assertOk()
            ->assertViewIs('app.banks.edit')
            ->assertViewHas('bank');
    }

    /**
     * @test
     */
    public function it_updates_the_bank()
    {
        $bank = Bank::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence(15),
        ];

        $response = $this->put(route('banks.update', $bank), $data);

        $data['id'] = $bank->id;

        $this->assertDatabaseHas('banks', $data);

        $response->assertRedirect(route('banks.edit', $bank));
    }

    /**
     * @test
     */
    public function it_deletes_the_bank()
    {
        $bank = Bank::factory()->create();

        $response = $this->delete(route('banks.destroy', $bank));

        $response->assertRedirect(route('banks.index'));

        $this->assertSoftDeleted($bank);
    }
}
