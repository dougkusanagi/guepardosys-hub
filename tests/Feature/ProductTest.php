<?php

use App\Models\Company;
use App\Models\Product;
use App\Models\User;

use function Pest\Laravel\get;
use function Pest\Laravel\actingAs;

it('renders product.index for authenticated user', function () {
    asUser()
        ->get(route('product.index'))
        ->assertOk();
});

it('renders product.create for authenticated user', function () {
    asUser()
        ->get(route('product.create'))
        ->assertOk();
});

it('renders product.edit for users from same company', function () {
    $company = Company::factory()->create();
    $user = User::factory()->create(['company_id' => $company->id]);
    $product = Product::factory()->create(['company_id' => $company->id]);

    actingAs($user)
        ->get(route('product.edit', $product->id))
        ->assertOk();
});

it('requires authentication to open product.index ', function () {
    get(route('product.index'))
        ->assertRedirect(route('login'));
});

it('requires to be from same company to open product.edit', function () {
    $company_1 = Company::factory()->create();
    $product_company_1 = Product::factory()->create(['company_id' => $company_1->id]);
    $company_2 = Company::factory()->create();
    $user_from_company_2 = User::factory()->create(['company_id' => $company_2->id]);

    $response = actingAs($user_from_company_2)
        ->get(route('product.edit', $product_company_1->id));

    expect($response)->assertForbidden();
});

it('requires to be from same company to delete a product', function () {
    $company_company_1 = Company::factory()->create();
    $company_company_2 = Company::factory()->create();
    $user_company_2 = User::factory()->create(['company_id' => $company_company_2->id]);
    $product_company_1 = Product::factory()->create(['company_id' => $company_company_1->id]);

    $response = actingAs($user_company_2)->delete(route('product.destroy', $product_company_1->id));

    expect($response)->assertForbidden();
});

it('creates a product', function () {
    $product = Product::factory()->raw();

    $response = asUser()->post(route('product.store'), $product);

    $response->assertRedirect(route('product.edit', 1));
});

it('updates a product', function () {
    $company = Company::factory()->create();
    $user = User::factory()->create(['company_id' => $company->id]);
    $product = Product::factory()->create(['company_id' => $company->id]);

    $productArray = $product->toArray();
    $productArray['name'] = 'Updated';
    $response = actingAs($user)->put(
        route('product.update', $product->id),
        $productArray
    );

    $response->assertRedirect(route('product.edit', $product->id));
    expect($product->refresh()->name)->toEqual('Updated');
});

it('deletes a product', function () {
    $company = Company::factory()->create();
    $user = User::factory()->create(['company_id' => $company->id]);
    $product = Product::factory()->create(['company_id' => $company->id]);

    $response = actingAs($user)
        ->delete(
            route('product.destroy', $product->id)
        );

    expect($response)->assertRedirect(route('product.index'));
    expect(Product::find($product->id))->toBeNull();
});
