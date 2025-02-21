<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

/**
 * Class TrustProxies
 *
 * @package App\Http\Middleware
 */
class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var array<int, string>|string|null
     */
    protected $proxies;

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    protected $headers;

    /**
     * TrustProxies Constructor.
     */
    public function __construct()
    {
        $this->proxies = config('trusted-proxy.proxies');
        $this->headers = config('trusted-proxy.headers');
    }

    /**
     * Sets the trusted proxies on the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    protected function setTrustedProxyIpAddresses(Request $request): void
    {
        $trustedIps = $this->proxies();

        if (is_null($trustedIps) && (($_ENV['LARAVEL_CLOUD'] ?? false) === '1' || ($_SERVER['LARAVEL_CLOUD'] ?? false) === '1')) {
            $trustedIps = '*';
        }

        // Trust any IP address that calls us.
        if ($trustedIps === '*' || $trustedIps === '**') {
            $this->setTrustedProxyIpAddressesToTheCallingIp($request);
            return;
        }

        // Support IPs addresses separated by comma.
        $trustedIps = is_string($trustedIps)
            ? array_map('trim', explode(',', $trustedIps))
            : $trustedIps;

        /**
         * ThuyVu custom: Trust IP addresses from X_FORWARDED_FOR header.
         */
        if (is_array($trustedIps)) {
            $forwardedIps = $request->headers->get('X_FORWARDED_FOR');
            $forwardedIps = !empty($forwardedIps)
                ? array_map('trim', explode(',', $forwardedIps))
                : [];
            foreach ($forwardedIps as $forwardedIp) {
                foreach ($trustedIps as $trustedIp) {
                    $i = strpos($trustedIp, ':');
                    $trustedIp = $i ? substr($trustedIp, 0, $i) : $trustedIp;

                    $i = strpos($trustedIp, '/');
                    $trustedIp = $i ? substr($trustedIp, 0, $i) : $trustedIp;

                    if (!in_array($forwardedIp, $trustedIps) && preg_match("/$trustedIp/", $forwardedIp)) {
                        $trustedIps[] = $forwardedIp;
                    }
                }
            }
        }

        // Only trust specific IP addresses.
        if (is_array($trustedIps)) {
            $this->setTrustedProxyIpAddressesToSpecificIps($request, $trustedIps);
        }
    }
}
