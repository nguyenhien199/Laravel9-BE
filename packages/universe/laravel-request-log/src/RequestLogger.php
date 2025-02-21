<?php

namespace Universe\RequestLog;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

/**
 * Class RequestLogger
 *
 * @package Universe\RequestLog
 */
class RequestLogger
{
    /**
     * @var array RequestLogger configs.
     */
    protected array $config;

    /**
     * @var string Unique Request ID.
     */
    protected string $uniqId;

    public function __construct()
    {
        $this->config = (array)config('request-log', []);
        $this->uniqId = uniqid();
    }

    /**
     * Request info logging.
     *
     * @param Request $request
     */
    public function logRequest(Request $request): void
    {
        if (!$this->isAllowed($request)) {
            return;
        }
        $channel = Arr::get($this->config, 'channels.logger', []);
        Log::build($channel)
            ->info($this->logMessageForRequest($request), [
                'context' => [
                    'method'  => strtoupper($request->method()),
                    'uri'     => $request->getPathInfo(),
                    'host'    => $request->getSchemeAndHttpHost(),
                    'inputs'  => $this->requestInputFormat($request),
                    'files'   => $this->requestFileFormat($request),
                    'headers' => $this->requestHeaderFormat($request),
                ],
                'extra'   => [
                    'user_id'    => $this->requestUserFormat($request),
                    'client_ip'  => $request->getClientIp(),
                    'client_ips' => $request->getClientIps(),
                    'user_agent' => $request->userAgent(),
                    'url'        => $request->url(),
                    'query'      => $request->getQueryString(),
                    'referrer'   => $request->headers->get('referrer'),
                ],
            ]);
    }

    /**
     * Response info logging.
     *
     * @param Request         $request
     * @param SymfonyResponse $response
     */
    public function logResponse(Request $request, SymfonyResponse $response): void
    {
        if (!$this->isAllowed($request)) {
            return;
        }
        $channel = Arr::get($this->config, 'channels.logger', []);
        Log::build($channel)
            ->info($this->logMessageForResponse($request), [
                'context' => [
                    'duration'  => $this->durationFormat(microtime(true) - LARAVEL_START),
                    'status'    => $response->getStatusCode(),
                    'exception' => $this->responseExceptionFormat($response),
                    'content'   => $this->responseContentFormat($response, $request->wantsJson()),
                ],
                'extra'   => [
                    'user_id' => $this->requestUserFormat($request),
                    'method'  => strtoupper($request->method()),
                    'url'     => $request->url(),
                    'query'   => $request->getQueryString(),
                    'inputs'  => $this->requestInputFormat($request),
                    'files'   => $this->requestFileFormat($request),
                    'headers' => $this->requestHeaderFormat($request),
                ],
            ]);
    }

    /**
     * Check whether logging requests are allowed.
     *
     * @param Request $request
     * @return bool
     */
    private function isAllowed(Request $request): bool
    {
        $isEnabled = Arr::get($this->config, 'enabled', true);
        if ($isEnabled === false) {
            return false;
        }

        $channel = Arr::get($this->config, 'channels.logger', []);
        if (empty($channel)) {
            return false;
        }

        $pathExcludes = Arr::get($this->config, 'path_excludes', []);
        if (is_array($pathExcludes) && !empty($pathExcludes)) {
            $requestPath = $request->path();
            foreach ($pathExcludes as $pathExclude) {
                $pathExclude = mb_trim($pathExclude);
                if (
                    in_array($pathExclude, ['*', '**', '*/*', '/'])
                    ||
                    (
                        !empty(mb_trim($pathExclude, '/'))
                        &&
                        str_starts_with($requestPath, mb_trim($pathExclude, '/'))
                    )
                ) {
                    return false;
                }
            }
        }

        $requestAgent = $request->userAgent();
        $agentExcludes = Arr::get($this->config, 'agent_excludes', []);
        if (is_array($agentExcludes) && !empty($agentExcludes)) {
            foreach ($agentExcludes as $agentExclude) {
                $agentExclude = mb_trim($agentExclude);
                if (
                    in_array($agentExclude, ['*', '**'])
                    ||
                    (!empty($agentExclude) && $requestAgent == $agentExclude)
                ) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Gen Log Message for Request.
     *
     * @param Request $request
     * @return string
     */
    private function logMessageForRequest(Request $request): string
    {
        return "REQUEST [{$this->uniqId}:{$request->getPathInfo()}]";
    }

    /**
     * Gen Log Message for Response.
     *
     * @param Request $request
     * @return string
     */
    private function logMessageForResponse(Request $request): string
    {
        return "RESPONSE [{$this->uniqId}:{$request->getPathInfo()}]";
    }

    /**
     * Format Request User info.
     *
     * @param Request $request
     * @return string|null
     */
    private function requestUserFormat(Request $request): ?string
    {
        $user = $request->user();
        if (empty($user)) {
            return null;
        }
        return $user->getMorphClass().'('.$user->{$user->getKeyName()}.')';
    }

    /**
     * Format the Request Header except for a specified array of keys.
     *
     * @param Request $request
     * @return array
     */
    private function requestHeaderFormat(Request $request): array
    {
        $headerExcepts = Arr::get($this->config, 'header_excepts', []);

        $headers = $request->headers->all();

        return Arr::except($headers, $headerExcepts);
    }

    /**
     * Format the Request Inout for except for a specified array of keys.
     *
     * @param Request $request
     * @return array
     */
    private function requestInputFormat(Request $request): array
    {
        $inputExcepts = Arr::get($this->config, 'input_excepts', []);

        $inputs = $request->all();

        return Arr::except($inputs, $inputExcepts);
    }

    /**
     * Format the Request File name.
     *
     * @param Request $request
     * @return array
     */
    private function requestFileFormat(Request $request): array
    {
        return collect(iterator_to_array($request->files))
            ->map([$this, 'flatFiles'])
            ->flatten()
            ->toArray();
    }

    /**
     * Flat Files.
     * (using callback -> public)
     *
     * @param mixed $file
     * @return array|string
     */
    public function flatFiles(mixed $file): array|string
    {
        if ($file instanceof \Symfony\Component\HttpFoundation\File\UploadedFile) {
            return $file->getClientOriginalName();
        }
        if (is_array($file)) {
            return array_map([$this, 'flatFiles'], $file);
        }

        return (string)$file;
    }

    /**
     * Format Response Exception.
     *
     * @param SymfonyResponse $response
     * @return array|null
     */
    private function responseExceptionFormat(SymfonyResponse $response): ?array
    {
        $e = !empty($response->exception) ? $response->exception : null;
        return !empty($e) ? [
            'class' => $e::class,
            'file'  => $e->getFile(),
            'line'  => $e->getLine(),
            'code'  => $e->getCode(),
            'msg'   => $e->getMessage(),
        ] : null;
    }

    /**
     * Format Response Content.
     *
     * @param SymfonyResponse $response
     * @param bool            $requestWantsJson
     * @return array|null
     */
    private function responseContentFormat(SymfonyResponse $response, bool $requestWantsJson = false): ?array
    {
        // Redirect Response
        if ($response instanceof \Symfony\Component\HttpFoundation\RedirectResponse) {
            $errors = (method_exists($response, 'getSession') && !empty($response->getSession())) ? $response->getSession()->get('errors', []) : [];
            $errors = ($errors instanceof \Illuminate\Support\ViewErrorBag) ? $errors->toArray() : $errors;
            return [
                'type'       => 'redirect',
                'target_url' => $response->getTargetUrl(),
                'errors'     => $errors,
            ];
        }
        // Response View(html)
        elseif (!empty($response->original) && $response->original instanceof \Illuminate\View\View) {
            return [
                'type' => 'html',
                'data' => $response->original->getData(),
                'view' => $response->original->getName(),
                'path' => $response->original->getPath(),
            ];
        }
        // Json Response
        elseif ($response instanceof \Symfony\Component\HttpFoundation\JsonResponse || $requestWantsJson) {
            return [
                'type' => 'json',
                'data' => $response->getContent(),
            ];
        }
        // BinaryFile Response
        elseif ($response instanceof \Symfony\Component\HttpFoundation\BinaryFileResponse) {
            return [
                'type' => 'file',
                'data' => [
                    'filename'  => $response->getFile()->getFilename(),
                    'extension' => $response->getFile()->getExtension(),
                    'pathname'  => $response->getFile()->getPathname(),
                    'filesize'  => $response->getFile()->getSize(),
                ],
            ];
        }
        // StreamedJson Response
        elseif ($response instanceof \Symfony\Component\HttpFoundation\StreamedJsonResponse) {
            return [
                'type' => 'streamed-json',
                'data' => null,
            ];
        }
        // Streamed Response
        elseif ($response instanceof \Symfony\Component\HttpFoundation\StreamedResponse) {
            return [
                'type' => 'streamed',
                'data' => null,
            ];
        }
        else {
            if (!empty($response->exception)) {
                return null;
            }
            else {
                return [
                    'type' => 'unknown',
                    'data' => $response->getContent(),
                ];
            }
        }
    }

    /**
     * Format Duration.
     *
     * @param float $seconds
     * @return string
     */
    private function durationFormat(float $seconds): string
    {
        if ($seconds < 0.001) {
            return round($seconds * 1000000).'μs';
        }
        elseif ($seconds < 0.1) {
            return round($seconds * 1000, 2).'ms';
        }
        elseif ($seconds < 1) {
            return round($seconds * 1000).'ms';
        }
        return round($seconds, 2).'s';
    }
}
