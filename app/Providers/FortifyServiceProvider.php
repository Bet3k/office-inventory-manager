<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::authenticateUsing(function (Request $request) {
            $user = User::query()->where('email', $request->string('email')->value())->first();

            if (! $user) {
                throw ValidationException::withMessages(['email' => 'Invalid E-Mail or Password provided.']);
            }

            if (! Hash::check($request->string('password')->value(), (string) $user->password)) {
                throw ValidationException::withMessages(['email' => 'Invalid E-Mail or Password provided.']);
            }

            if (! $user->is_active) {
                throw ValidationException::withMessages(['email' => 'Your account is not active.']);
            }

            $user->update(['last_login_at' => now(),]);

            return $user;
        });
    }
}
