<?php

use App\Models\Department;
use Inertia\Testing\AssertableInertia as Assert;

test('department can be deleted', function () {
    $user = createUser();

    $dataType = Department::factory()->create([
                                                'department' => 'Name',
                                                'user_id' => $user->id
                                            ]);

    $this
        ->actingAs($user)
        ->get(route('department.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('department/index')
                ->has('departments.data', 1, fn (Assert $page) => $page
                    ->where('department', 'Name')
                    ->etc())
        );

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->delete(route('department.destroy', $dataType->id), [
            'password' => 'Password1#',
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('department/index')
                ->has('departments.data', 0)
        );
});

test('department cannot be deleted with wrong password', function () {
    $user = createUser();

    $dataType = Department::factory()->create([
                                                'department' => 'Names',
                                                'user_id' => $user->id
                                            ]);

    $this
        ->actingAs($user)
        ->get(route('department.index'))
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('department/index')
                ->has('departments.data', 1, fn (Assert $page) => $page
                    ->where('department', 'Names')
                    ->etc())
        );

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->delete(route('department.destroy', $dataType->id), [
            'password' => 'wong-password-123',
        ])
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('department/index')
                ->has('departments.data', 1, fn (Assert $page) => $page
                    ->where('department', 'Names')
                    ->etc())
                ->where('errors.password', 'The password is incorrect.')
        );
});
