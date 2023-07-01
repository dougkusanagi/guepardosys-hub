<?php

use App\Models\Tenant;
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

it('renders product.edit for users from same tenant', function () {
    $tenant = Tenant::factory()->create();
    $user = User::factory()->create(['tenant_id' => $tenant->id]);
    $product = Product::factory()->create(['tenant_id' => $tenant->id]);

    actingAs($user)
        ->get(route('product.edit', $product->id))
        ->assertOk();
});

it('requires authentication to open product.index ', function () {
    get(route('product.index'))
        ->assertRedirect(route('login'));
});

it('requires to be from same tenant to open product.edit', function () {
    $tenant_1 = Tenant::factory()->create();
    $product_tenant_1 = Product::factory()->create(['tenant_id' => $tenant_1->id]);
    $tenant_2 = Tenant::factory()->create();
    $user_from_tenant_2 = User::factory()->create(['tenant_id' => $tenant_2->id]);

    $response = actingAs($user_from_tenant_2)
        ->get(route('product.edit', $product_tenant_1->id));

    expect($response)->assertForbidden();
});

it('requires to be from same tenant to delete a product', function () {
    $tenant_1 = Tenant::factory()->create();
    $tenant_2 = Tenant::factory()->create();
    $user_tenant_2 = User::factory()->create(['tenant_id' => $tenant_2->id]);
    $product_tenant_1 = Product::factory()->create(['tenant_id' => $tenant_1->id]);

    $response = actingAs($user_tenant_2)->delete(route('product.destroy', $product_tenant_1->id));

    expect($response)->assertForbidden();
});

it('creates a product', function () {
    $product = Product::factory()->raw();

    $response = asUser()->post(route('product.store'), $product);

    $response->assertRedirect(route('product.edit', 1));
});

it('updates a product', function () {
    $tenant = Tenant::factory()->create();
    $user = User::factory()->create(['tenant_id' => $tenant->id]);
    $product = Product::factory()->create(['tenant_id' => $tenant->id]);

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
    $tenant = Tenant::factory()->create();
    $user = User::factory()->create(['tenant_id' => $tenant->id]);
    $product = Product::factory()->create(['tenant_id' => $tenant->id]);

    $response = actingAs($user)
        ->delete(
            route('product.destroy', $product->id)
        );

    expect($response)->assertRedirect(route('product.index'));
    expect(Product::find($product->id))->toBeNull();
});
