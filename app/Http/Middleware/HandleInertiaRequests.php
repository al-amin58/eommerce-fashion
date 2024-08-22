<?php

namespace App\Http\Middleware;

use Inertia\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return array_merge(parent::share($request), [
            'auth' => Auth::check() ? [
                'user' => Auth::user()->load('addresses'),
                'MAIN_URL' => config('app.url'),
                'ADMIN_URL' => config('app.url')."/panel",
                'APP_NAME' => config('app.name')
            ] : ['MAIN_URL' => config('app.url'), 'APP_NAME' => config('app.name')],
            'message' => fn () => $request->session()->get('message')

        ]);
    }
}
