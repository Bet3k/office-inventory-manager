<?php

namespace App\Http\Middleware;

use App\Dtos\UserDto;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        /** @var ?User $user */
        $user = $request->user();

        /** @var array<string, mixed> $shared */
        $shared = [
            ...parent::share($request),
            'name' => config('app.name'),
            'auth' => [
                'user' => $user ? UserDto::fromModel($user)->toArray() : [],
            ],
            'ziggy' => fn (): array => [
                ...(new Ziggy())->toArray(),
                'location' => $request->url(),
            ],
            'sidebarOpen' => ! $request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
            'flash' => function () {
                // A useEffect in the AppLayout component will be used to display
                // toasts and form components just making requests.
                // Messages will come from Laravel.
                // The error here should not be confused with the errors prop in Inertia.
                return [
                    'success' => session()->get('success'),
                    'info' => session()->get('info'),
                    'warning' => session()->get('warning'),
                    'error' => session()->get('error'),
                ];
            },
        ];

        return $shared;
    }
}
