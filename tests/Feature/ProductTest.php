<?php

it('requires authentication for product.index ', function () {
    expect($this->get(route('product.index')))
        ->assertRedirect(route('login'));
});

it('has home')->todo();
