<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Inspiring;
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

        [$message, $author] = str(Inspiring::quotes()->random())->explode(' - ');

        return [
            ...parent::share($request),

            'auth' => [
                'user' => $request->user(),
                'permissions' => fn() => $request->user()?->getAllPermissions()->pluck('name') ?? [],
                // 'roles' => $request->user() ? $request->user()->getRoleNames() : [],
            ],
            // 'ziggy' => [
            //     ...(new Ziggy)->toArray(),
            //     'location' => $request->url(),
            // ],
            // 'sidebarOpen' => $request->session()->get('sidebarOpen', false),
        ];
    }

    protected $middlewareGroups = [
        'web' => [
            // ...
            \App\Http\Middleware\BlockedUserLogout::class,
        ],
    ];
    // /**
    //  * The middleware that should be applied to the request.
    //  *
    //  * @see https://inertiajs.com/middleware
    //  *
    //  * @return array<int, class-string>
    //  */
    // public function middleware(): array
    // {
    //     return [
    //         \App\Http\Middleware\BlockedUserLogout::class,
    //         // Add other middleware as needed
    //     ];
    // }
}
