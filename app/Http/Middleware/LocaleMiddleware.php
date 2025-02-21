<?php

namespace App\Http\Middleware;

use App\Constants\AppConst;
use Closure;
use Illuminate\Http\Request;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class LocaleMiddleware
 *
 * @package App\Http\Middleware
 */
class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function handle(Request $request, Closure $next): mixed
    {
        // Check Header request
        $headerLocale = strtolower($request->header('X-LANG', ''));
        $headerLocale = !empty($headerLocale) && validation_locale($headerLocale) ? $headerLocale : '';

        // Check Input params
        $paramLocale = strtolower($request->input('lang', ''));
        $paramLocale = !empty($paramLocale) && validation_locale($paramLocale) ? $paramLocale : '';

        // Check Session
        $sessionLocale = strtolower(session()->has('locale') ? strtolower(session()->get('locale')) : '');
        $sessionLocale = !empty($sessionLocale) && validation_locale($sessionLocale) ? $sessionLocale : '';

        // Check User lang
        $user = $request->user();
        $userLocale = strtolower(!empty($user->lang) ? $user->lang : '');
        $userLocale = !empty($userLocale) && validation_locale($userLocale) ? $userLocale : '';

        // App locale
        $appLocale = app_locale();

        // Locale priority: Header -> Param -> Session -> User/Customer -> App config.
        $locale = !empty($headerLocale) ? $headerLocale
            : (!empty($paramLocale) ? $paramLocale
                : (!empty($sessionLocale) ? $sessionLocale
                    : (!empty($userLocale) ? $userLocale
                        : $appLocale
                    )
                )
            );
        $locale = strtolower($locale);

        // TODO: change with API (Admin or Front) or WEB (Front-Web or Admin-CMS).
        // For API (response using Json)
        if ($request->wantsJson() && AppConst::isApiUrlRequest($request)) {
            // Locale is enabled and allowed to be changed.
            allowed_to_change_locale() && set_all_locale($locale);
            allowed_to_change_locale() || set_app_locale($locale);
        }
        // For Web
        else {
            // With Admin-CMS -> Default does not change Locale with all.
            if (AppConst::isAdminUrlRequest($request)) {
                set_app_locale($locale);
            }
            // With Front-Web.
            else {
                // Locale is enabled and allowed to be changed.
                allowed_to_change_locale() && set_all_locale($locale);
                allowed_to_change_locale() || set_app_locale($locale);
            }
        }

        return $next($request);
    }
}
