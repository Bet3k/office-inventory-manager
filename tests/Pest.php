<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
use PragmaRX\Google2FA\Google2FA;

pest()->extend(Tests\TestCase::class)
    ->use(Illuminate\Foundation\Testing\RefreshDatabase::class)
    ->in('Feature');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function createUser()
{
    $user = User::factory()->create([
        'email' => 'john.doe@mail.com',
        'password' => Hash::make('Password1#')
    ]);

    $role = Role::create(['name' => 'super-admin']);

    $permissions = Permission::all();

    $role->syncPermissions($permissions);

    $user->assignRole('super-admin');

    return $user;
}

/**
 * @throws IncompatibleWithGoogleAuthenticatorException
 * @throws SecretKeyTooShortException
 * @throws InvalidCharactersException
 */
function twoFactorUser()
{
    $google2fa = new Google2FA();
    $secret = $google2fa->generateSecretKey();
    $recoveryCodes = collect(range(1, 8))->map(function () {
        return Str::random(10).'-'.Str::random(10);
    })->all();

    return User::factory()->create([
        'password' => Hash::make('Password1#'),
        'two_factor_secret' => Crypt::encrypt($secret),
        'two_factor_recovery_codes' => Crypt::encrypt(json_encode($recoveryCodes)),
        'two_factor_confirmed_at' => now(),
    ]);
}
