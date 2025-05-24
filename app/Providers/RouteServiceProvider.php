<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Mcamara\LaravelLocalization\Traits\LoadsTranslatedCachedRoutes;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    use LoadsTranslatedCachedRoutes;

    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        ### Start - Hide Website Frontend Pages ###
        $locale = LaravelLocalization::setLocale();
        if (
            !is_null(Request::segment(1))
            && !request()->is('/storage/*')
            && !request()->is('filemanager/*')
            && !request()->is('filemanager')
            && !request()->is('laravel-filemanager/*')
            && !request()->is($locale . '/dashboard')
            && !request()->is($locale . '/dashboard/*')
            && !request()->is($locale . '/vendor-dashboard')
            && !request()->is($locale . '/vendor-dashboard/*')
            && !request()->is($locale . '/driver-dashboard')
            && !request()->is($locale . '/driver-dashboard/*')
            && !request()->is($locale . '/logout')
            && !request()->is($locale . '/privacy-policy')
            && !request()->is($locale . '/users/deactivate')
            && !request()->is('api/*')
            && !request()->is('reset/*')
            && !request()->is($locale . '/reset')
            && !request()->is($locale . '/reset/*')
        ) {
            return abort(404);
        }
        ### End - Hide Website Frontend Pages ###

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {

        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}
