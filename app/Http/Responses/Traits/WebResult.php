<?php

namespace App\Http\Responses\Traits;

/**
 * Trait WebResult
 *
 * @package App\Http\Responses\Traits
 */
trait WebResult
{
    use Core\BaseResult;

    /**
     * Create a new redirect response to the given path.
     *
     * @param string    $path    <p>The given path.</p>
     * @param int       $status  <p>Http status Code.</p>
     * @param array     $headers <p>Extend request Headers.</p>
     * @param bool|null $secure  <p>Set is Secure for Schema.</p>
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectTo(string $path, int $status = HTTP_FOUND, array $headers = [], bool|null $secure = null)
    {
        return response()->redirectTo($path, $status, $headers, $secure);
    }

    /**
     * Create a new redirect response to a named route.
     *
     * @param string $route      Name of a Route
     * @param mixed  $parameters Attached parameters
     * @param int    $status     <p>Http status Code.</p>
     * @param array  $headers    <p>Extend request Headers.</p>
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectToRoute(string $route, mixed $parameters = [], int $status = HTTP_FOUND, array $headers = [])
    {
        return response()->redirectToRoute($route, $parameters, $status, $headers);
    }

    /**
     * Create a new redirect response to a controller action.
     *
     * @param string $action     <p>A controller action.</p>
     * @param mixed  $parameters <p>Attached parameters.</p>
     * @param int    $status     <p>Http status Code.</p>
     * @param array  $headers    <p>Extend request Headers.</p>
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectToAction(string $action, mixed $parameters = [], int $status = HTTP_FOUND, array $headers = [])
    {
        return response()->redirectToRoute($action, $parameters, $status, $headers);
    }

    /**
     * Create a new redirect response to the previous location.
     *
     * @param int   $status   <p>Http status Code.</p>
     * @param array $headers  <p>Extend request Headers.</p>
     * @param mixed $fallback <p>Set Fallback for Redirect action.</p>
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectBack(int $status = HTTP_FOUND, array $headers = [], bool $fallback = false)
    {
        return redirect()->back($status, $headers, $fallback);
    }

    /**
     * Create a new redirect response, while putting the current URL in the session.
     *
     * @param string    $path    <p>The given path.</p>
     * @param int       $status  <p>Http status Code.</p>
     * @param array     $headers <p>Extend request Headers.</p>
     * @param bool|null $secure  <p>Set is Secure for Schema.</p>
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectGuest(string $path, int $status = HTTP_FOUND, array $headers = [], bool|null $secure = null)
    {
        return response()->redirectGuest($path, $status, $headers, $secure);
    }

    /**
     * Create a new redirect response to the previously intended location.
     *
     * @param string    $default <p>The given path.</p>
     * @param int       $status  <p>Http status Code.</p>
     * @param array     $headers <p>Extend request Headers.</p>
     * @param bool|null $secure  <p>Set is Secure for Schema.</p>
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectToIntended(string $default = '/', int $status = HTTP_FOUND, array $headers = [], bool|null $secure = null)
    {
        return response()->redirectToIntended($default, $status, $headers, $secure);
    }
}
