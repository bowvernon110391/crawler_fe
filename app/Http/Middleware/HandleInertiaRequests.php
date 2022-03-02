<?php

namespace App\Http\Middleware;

use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        logger('Inertia: ' . $request->fullUrl());
        return array_merge(
            // parent data
            parent::share($request), 
            // our app shared data
            [
                // some shared data
                'user' => $request->user(),
                'token' => optional($request->user())->last_token
            ], 
            // login url
            $request->user() ? [] : [
                'sso_login_url' => config('sso.login_url')
            ],
            // route data
            [
                'route' => [
                    'name' => $request->route()->getName(),
                    'breadcrumbs' => Breadcrumbs::generate(
                        $request->route()->getName(),
                        ...$request->route()->parameters()
                    )
                ]
            ]
        );
    }
}
