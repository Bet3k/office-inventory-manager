<?php


use App\Models\MemberOfStaff;
use Inertia\Testing\AssertableInertia as Assert;

test('member of staff can be deleted with correct password', function () {
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
        ->delete(route('member-of-staff.destroy', $memberOfStaff->id), [
            'password' => 'Password1#',
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('member-of-staff/index')
                ->has('membersOfStaff.data', 0)
        );
});

test('member of staff cannot be deleted with wrong password', function () {
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
        ->delete(route('member-of-staff.update', $memberOfStaff->id), [
            'password' => 'wrong-password',
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('member-of-staff/index')
                ->has('membersOfStaff.data', 1, fn (Assert $page) => $page
                    ->where('first_name', 'John')
                    ->where('last_name', 'Doe')
                    ->etc())
        )
    ;
});
