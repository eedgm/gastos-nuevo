<?php

namespace Tests\Feature\Api;

use App\Models\User;
use App\Models\Bank;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BankTest extends TestCase
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
    public function it_gets_banks_list()
    {
        $banks = Bank::factory()
            ->count(5)
            ->create();

        $response = $this->getJson(route('api.banks.index'));

        $response->assertOk()->assertSee($banks[0]->name);
    }

    /**
     * @test
     */
    public function it_stores_the_bank()
    {
        $data = Bank::factory()
            ->make()
            ->toArray();

        $response = $this->postJson(route('api.banks.store'), $data);

        $this->assertDatabaseHas('banks', $data);

        $response->assertStatus(201)->assertJsonFragment($data);
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

        $response = $this->putJson(route('api.banks.update', $bank), $data);

        $data['id'] = $bank->id;

        $this->assertDatabaseHas('banks', $data);

        $response->assertOk()->assertJsonFragment($data);
    }

    /**
     * @test
     */
    public function it_deletes_the_bank()
    {
        $bank = Bank::factory()->create();

        $response = $this->deleteJson(route('api.banks.destroy', $bank));

        $this->assertSoftDeleted($bank);

        $response->assertNoContent();
    }
}
