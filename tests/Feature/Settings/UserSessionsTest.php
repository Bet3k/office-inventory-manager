<?php

use Inertia\Testing\AssertableInertia as Assert;

test('user can see session list', function () {
    $user = createUser();

    DB::table('sessions')->insert([
        'id' => Str::random(40),
       'user_id' => $user->id,
       'ip_address' => '127.0.0.1',
       'user_agent' => 'FakeAgent',
       'last_activity' => now(),
       'payload' => base64_encode(serialize(session()->all())),
    ]);

    $this->actingAs($user)->get(route('settings.create'));


    $this
        ->followingRedirects()
        ->get(route('settings.create'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('settings/index')
                ->has(
                    'sessions',
                    1,
                    fn (Assert $page) => $page
                    ->where('user_id', $user->id)
                    ->where('ip_address', '127.0.0.1')
                    ->where('user_agent', 'FakeAgent')
                    ->etc()
                )
                ->where('auth.user.email', $user->email)
        );
});

test('user can delete session', function () {
    $user = createUser();

    $sessionId = Str::random(40);

    DB::table('sessions')->insert([
        'id' => $sessionId,
        'user_id' => $user->id,
        'ip_address' => '127.0.0.1',
        'user_agent' => 'FakeAgent',
        'last_activity' => now(),
        'payload' => base64_encode(serialize(session()->all())),
    ]);

    $session = DB::table('sessions')->where('id', $sessionId)->first();

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->get(route('settings.create'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('settings/index')
                ->has(
                    'sessions',
                    1,
                    fn (Assert $page) => $page
                        ->where('user_id', $user->id)
                        ->where('ip_address', '127.0.0.1')
                        ->where('user_agent', 'FakeAgent')
                        ->etc()
                )
                ->where('auth.user.email', $user->email)
        );

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->delete(route('sessions.destroy', $session->id))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('settings/index')
        );

    $deletedSession = DB::table('sessions')->where('id', $session->id)->first();

    expect($deletedSession)->toBeNull();
});

test('user can delete all sessions', function () {
    $user = createUser();

    $sessionIds = [Str::random(40), Str::random(40), Str::random(40)];

    foreach ($sessionIds as $sessionId) {
        DB::table('sessions')->insert([
            'id' => $sessionId,
            'user_id' => $user->id,
            'ip_address' => '127.0.0.1',
            'user_agent' => 'FakeAgent',
            'last_activity' => now()->timestamp,
            'payload' => base64_encode(serialize(session()->all())),
        ]);
    }

    $sessionsBefore = DB::table('sessions')->where('user_id', $user->id)->count();
    expect($sessionsBefore)->toBeGreaterThanOrEqual(2);

    $this->actingAs($user)->get(route('settings.create'));

    $this
        ->actingAs($user)
        ->followingRedirects()
        ->delete(route('sessions.end.all'))
        ->assertOk()
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('auth/login')
        );

    $sessionsAfter = DB::table('sessions')->where('user_id', $user->id)->count();
    expect($sessionsAfter)->toBe(0);
});
