<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\ProductStatusEnum;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = fake()->sentence();

        return [
            'name' => $name,
            'slug' => Str::slug($name, '-'),
            'model' => random_int(1, 9999999999999),
            'description' => fake()->text(),
            'description_html' => fake()->text(400),
            'price' => fake()->randomNumber(4, true),
            'stock_virtual' => fake()->randomNumber(2),
            'stock_local' => fake()->randomNumber(2),
            'stock_local_min' => fake()->randomNumber(2),
            'status' => fake()->randomElement([
                ProductStatusEnum::Active->value,
                ProductStatusEnum::Inactive->value,
                ProductStatusEnum::Waiting->value,
            ]),
            'barcode' => fake()->ean13(),
            'ncm' => fake()->randomNumber(8, true),
            'weight' => fake()->randomNumber(4, true),
            'height' => fake()->randomNumber(4, true),
            'width' => fake()->randomNumber(4, true),
            'length' => fake()->randomNumber(4, true),
            'brand' => config('APP_NAME', 'Laravel'),
            'availability' => fake()->randomDigit(),
            'keywords' => implode(',', fake()->words(5)),
        ];
    }
}
