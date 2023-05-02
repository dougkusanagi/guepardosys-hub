<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use App\Models\ProductModel;
use App\Models\ProductModelPrefix;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach (['pdv', 'mdl', 'ca'] as $prefix) {
            ProductModelPrefix::create(['name' => $prefix]);
        }

        $allProductPrefixesIds = ProductModelPrefix::all()->pluck('id');

        /** @var \Illuminate\Database\Eloquent\Collection */
        $company_guepardo = Company::factory()->create(['name' => 'GuepardoSys'])->all();
        $companies = Company::factory(4)->create();
        $all_companies = $company_guepardo->merge($companies);

        // dd($company_guepardo);
        // dd($companies);
        // dd($all_companies);

        User::factory()
            ->for($company_guepardo[0])
            ->create([
                'name' => 'Douglas Lopes',
                'email' => 'dl.aguiar@yahoo.com.br',
            ]);

        foreach ($all_companies as $company) {
            Category::factory(5)
                ->for($company)
                ->has(
                    Product::factory(10)
                        ->for($company)
                        ->has(
                            ProductModel::factory()
                                ->state(['product_model_prefix_id' => $allProductPrefixesIds->random()])
                                ->for(ProductModelPrefix::factory(3))
                        )
                )
                ->create();

            User::factory()
                ->for($company)
                ->create();
        }
    }
}
