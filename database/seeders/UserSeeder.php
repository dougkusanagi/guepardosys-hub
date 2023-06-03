<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()
            ->for(Company::first())
            ->create([
                'name' => 'Example',
                'email' => 'example@email.com',
                'password' => bcrypt('password'),
            ]);

        Company::all()
            ->each(function (Company $company) {
                User::factory(4)
                    ->for($company)
                    ->create();
            });
    }
}
