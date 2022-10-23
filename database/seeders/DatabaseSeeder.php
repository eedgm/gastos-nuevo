<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Adding an admin user
        $user = \App\Models\User::factory()
            ->count(1)
            ->create([
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin'),
            ]);
        $this->call(PermissionsSeeder::class);

        // $this->call(AccountSeeder::class);
        $this->call(AssignSeeder::class);
        // $this->call(BankSeeder::class);
        $this->call(ClusterSeeder::class);
        $this->call(ColorSeeder::class);
        // $this->call(ExecutedSeeder::class);
        // $this->call(ExpenseSeeder::class);
        // $this->call(IncomeSeeder::class);
        $this->call(PurposeSeeder::class);
        $this->call(TypeSeeder::class);
        // $this->call(UserSeeder::class);
    }
}
