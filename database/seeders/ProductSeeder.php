<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Company;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Category::all()
            ->each(function (Category $category) {
                Product::factory(20)
                    ->for($category)
                    ->create([
                        'company_id' => $category->company_id,
                    ])
                    ->each(function (Product $product) {
                        $product->addMedia(public_path('/img/no-image.png'))
                            ->preservingOriginal()
                            ->toMediaCollection('images');
                    });
            });
    }
}
