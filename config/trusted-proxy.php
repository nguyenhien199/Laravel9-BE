<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Trusted Proxies
    |--------------------------------------------------------------------------
    | Set trusted proxy IP addresses.
    |
    | Both IPv4 and IPv6 addresses are supported, along with CIDR notation.
    | The "*" character is syntactic sugar within TrustedProxy to trust any proxy;
    | that connects directly to your server, a requirement when you cannot know
    | the address of your proxy (e.g. if using ELB or similar).
    |
    */

    'proxies' => array_merge([
        '127.0.0.1',    // For Localhost
        '172.17.0.1',   // For Docker
        '172.31.*.*',   // For Amazon LB
    ], !empty(env('APP_TRUSTED_PROXIES')) ? array_map('trim', explode(',', env('APP_TRUSTED_PROXIES'))) : []),

    /*
    |--------------------------------------------------------------------------
    | Respected Headers
    |--------------------------------------------------------------------------
    |
    | Which headers to use to detect proxy related data (For, Host, Proto, Port).
    | Options include:
    | - All headers (see below) - Trust all x-forwarded-* headers
    | - Illuminate\Http\Request::HEADER_FORWARDED - Use the FORWARDED header to establish trust
    | - Illuminate\Http\Request::HEADER_X_FORWARDED_AWS_ELB - If you are using AWS Elastic Load Balancer
    |
    | @link https://symfony.com/doc/current/deployment/proxies.html
    */

    'headers' => \Illuminate\Http\Request::HEADER_X_FORWARDED_FOR
        | \Illuminate\Http\Request::HEADER_X_FORWARDED_HOST
        | \Illuminate\Http\Request::HEADER_X_FORWARDED_PORT
        | \Illuminate\Http\Request::HEADER_X_FORWARDED_PROTO
        | \Illuminate\Http\Request::HEADER_X_FORWARDED_PREFIX
        | \Illuminate\Http\Request::HEADER_X_FORWARDED_AWS_ELB,

];