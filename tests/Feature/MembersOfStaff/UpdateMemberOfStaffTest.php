<?php


use App\Models\MemberOfStaff;
use Inertia\Testing\AssertableInertia as Assert;

test('member of staff can be update', function () {
    $user = createUser();

    $memberOfStaff = MemberOfStaff::factory()->create([
        'first_name' => 'John',
        'last_name' => 'Doe',
        'user_id' => $user->id
    ]);

    $this
        ->actingAs($user)
        ->get(route('member-of-staff.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('member-of-staff/index')
                ->has('membersOfStaff.data', 1, fn (Assert $page) => $page
                    ->where('first_name', 'John')
                    ->where('last_name', 'Doe')
                    ->etc())
        );

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->put(route('member-of-staff.update', $memberOfStaff->id), [
            'first_name' => 'Jack',
            'last_name' => 'Peters',
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('member-of-staff/index')
                ->has('membersOfStaff.data', 1, fn (Assert $page) => $page
                    ->where('first_name', 'Jack')
                    ->where('last_name', 'Peters')
                    ->etc())
        )
    ;
});

test('member of staff cannot be update with missing', function () {
    $user = createUser();

    $memberOfStaff = MemberOfStaff::factory()
        ->create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'user_id' => $user->id
        ]);

    $this
        ->actingAs($user)
        ->get(route('member-of-staff.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('member-of-staff/index')
                ->has('membersOfStaff.data', 1, fn (Assert $page) => $page
                    ->where('first_name', 'John')
                    ->where('last_name', 'Doe')
                    ->etc())
        );

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->put(route('member-of-staff.update', $memberOfStaff->id), [
            'first_name' => 'Jack',
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('member-of-staff/index')
                ->has('membersOfStaff.data', 1, fn (Assert $page) => $page
                    ->where('first_name', 'John')
                    ->where('last_name', 'Doe')
                    ->etc())
                ->where('errors.last_name', 'The last name field is required.')
        )
    ;
});
