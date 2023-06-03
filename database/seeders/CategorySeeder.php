<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Company::all()
            ->each(function (Company $company) {
                Category::factory(5)
                    ->for($company)
                    ->create();
            });
    }
}
