<?php

use App\Models\MemberOfStaff;
use Inertia\Testing\AssertableInertia as Assert;

test('user can see members of staff', function () {
    $user = createUser();

    MemberOfStaff::factory(15)->create(['user_id' => $user->id]);

    $this
        ->actingAs($user)
        ->get(route('member-of-staff.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('member-of-staff/index')
                ->has('membersOfStaff.data', 15)
        );
});
