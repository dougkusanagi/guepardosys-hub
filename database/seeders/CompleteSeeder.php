<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class CompleteSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            CompanySeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
