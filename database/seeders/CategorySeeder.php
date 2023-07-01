<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Tenant::all()
            ->each(function (Tenant $tenant) {
                Category::factory(5)
                    ->for($tenant)
                    ->create();
            });
    }
}
