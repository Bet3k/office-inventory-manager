<?php

use Inertia\Testing\AssertableInertia as Assert;

it('returns a successful response', function () {
    $response = $this->get('/');

    $response->assertInertia(
        fn (Assert $page) => $page
        ->component('welcome')
    );
});
