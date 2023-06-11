<?php

use App\Models\Company;
use App\Models\User;

it('renders page login', function () {
    expect($this->get(route('login')))
        ->assertOk();
});

it('renders product.index for authenticated user', function () {
    $company = Company::factory()->create();
    $user = User::factory()->create(['company_id' => $company->id]);

    expect($this->actingAs($user)->get(route('product.index')))
        ->assertOk();
});
