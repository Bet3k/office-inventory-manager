<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\ConnectedAccount;
use App\Models\MemberOfStaff;
use App\Models\Profile;
use App\Models\User;
use App\Policies\ConnectedAccountPolicy;
use App\Policies\MemberOfStaffPolicy;
use App\Policies\ProfilePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [

        Profile::class => ProfilePolicy::class,
        User::class => UserPolicy::class,
        ConnectedAccount::class => ConnectedAccountPolicy::class,
        MemberOfStaff::class => MemberOfStaffPolicy::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
