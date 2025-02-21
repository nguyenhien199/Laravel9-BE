<?php

namespace App\Providers;

use App\Constants\AuthConst;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

/**
 * Class RouteServiceProvider
 *
 * @package App\Providers
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * The path to the "home" route for Admin(CMS) application.
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME_ADMIN = '/admin';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            // Load routes of Front(Client-App) and Admin(CMS-App) API.
            Route::namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            // Load routes of Front(Web) and Admin(CMS).
            Route::namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for(AuthConst::GUARD_API_ADMIN, function (Request $request) {
            return Limit::perMinute(api_admin_rate_limit())->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for(AuthConst::GUARD_API_FRONT, function (Request $request) {
            return Limit::perMinute(api_front_rate_limit())->by($request->user()?->id ?: $request->ip());
        });
    }
}
