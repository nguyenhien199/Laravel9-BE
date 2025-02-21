<?php

namespace App\Http\Responses\Traits;

use App\Constants\ResponseConst;

/**
 * Trait ApiResult
 * (Responses json format)
 *
 * @package App\Http\Responses\Traits
 */
trait ApiResult
{
    use Core\BaseResult;

    /**
     * Return sample Api OK response.
     *
     * @param mixed $data <p>Data to return (default: []).</p>
     * @return \Illuminate\Http\JsonResponse
     */
    protected function sampleResult(mixed $data = [])
    {
        return $this->jsonResult($data, HTTP_OK);
    }

    /**
     * Return OK Api response.
     * (Swagger Response: Responses.Api.Core.Ok)
     *
     * @param mixed       $data    <p>Data to return   (default: []).</p>
     * @param string|null $message <p>Feedback message (default: __('Success')).</p>
     * @return \Illuminate\Http\JsonResponse {"code": "OK", "data": mixed, "message": string}
     */
    protected function okApiResult(mixed $data = [], string $message = null)
    {
        return $this->jsonResult([
            'code'    => ResponseConst::CODE_OK,
            'data'    => $data,
            'message' => mb_trim($message ?: __('messages.success')),
        ], HTTP_OK);
    }

    /**
     * Return BadRequest Api response.
     * (Swagger Response: Responses.Api.Core.BadRequest)
     *
     * @param string|null $code    <p>Error code    (default: 'BAD_REQUEST').</p>
     * @param string|null $message <p>Error message (default: __('A bad request, please try again.')).</p>
     * @param string|null $type    <p>Type of Error (default: 'BadRequestException').</p>
     * @return \Illuminate\Http\JsonResponse {"code": string, "message": string, "type" => string}
     */
    protected function badRequestApiResult(string $code = null, string $message = null, string $type = null)
    {
        return $this->jsonResult([
            'code'    => mb_trim($code ?: ResponseConst::CODE_BAD_REQUEST),
            'message' => mb_trim($message ?: __('messages.error.bad_request')),
            'type'    => mb_trim($type ?: 'BadRequestException'),
        ], HTTP_BAD_REQUEST);
    }

    /**
     * Return Unauthorized Api response.
     * (Swagger Response: Responses.Api.Core.Unauthorized)
     *
     * @param string|null $code    <p>Error code    (default: 'UNAUTHORIZED').</p>
     * @param string|null $message <p>Error message (default: __('An exception, failed authorization attempt.')).</p>
     * @param string|null $type    <p>Type of Error (default: 'AuthorizationException').</p>
     * @return \Illuminate\Http\JsonResponse {"code": string, "message": string, "type": string}
     */
    protected function unauthorizedApiResult(string $code = null, string $message = null, string $type = null)
    {
        return $this->jsonResult([
            'code'    => mb_trim($code ?: ResponseConst::CODE_UNAUTHORIZED),
            'message' => mb_trim($message ?: __('messages.error.unauthorized')),
            'type'    => mb_trim($type ?: 'AuthorizationException'),
        ], HTTP_UNAUTHORIZED);
    }

    /**
     * Return Forbidden Api response.
     * (Swagger Response: Responses.Api.Core.Forbidden)
     *
     * @param string|null $code    <p>Error code    (default: 'FORBIDDEN').</p>
     * @param string|null $message <p>Error message (default: __("You don't have permission to access.")).</p>
     * @param string|null $type    <p>Type of Error (default: 'ForbiddenException').</p>
     * @return \Illuminate\Http\JsonResponse {"code" => string, "message": string, "type": string}
     */
    protected function forbiddenApiResult(string $code = null, string $message = null, string $type = null)
    {
        return $this->jsonResult([
            'code'    => mb_trim($code ?: ResponseConst::CODE_FORBIDDEN),
            'message' => mb_trim($message ?: __('messages.error.forbidden')),
            'type'    => mb_trim($type ?: 'ForbiddenException'),
        ], HTTP_FORBIDDEN);
    }

    /**
     * Return NotFound Api response.
     * (Swagger Response: Responses.Api.Core.NotFound)
     *
     * @param string|null     $code    <p>Error code    (default: 'NOT_FOUND').</p>
     * @param string|null     $message <p>Error message (default: __('The resource you are looking for is not available.')).</p>
     * @param \Throwable|null $e       <p>Exception object.</p>
     * @param string|null     $type    <p>Type of Error (default: 'NotFoundException').</p>
     * @return \Illuminate\Http\JsonResponse {"code": string, "message": string, "type": string, "error": ?array}
     */
    protected function notFoundApiResult(string $code = null, string $message = null, \Throwable $e = null, string $type = null)
    {
        return $this->jsonResult([
            'code'    => mb_trim($code ?: ResponseConst::CODE_NOT_FOUND),
            'message' => mb_trim($message ?: $this->_getExceptionMessage($e, __('messages.error.not_found'))),
            'type'    => mb_trim($this->_getExceptionName($e, $type ?: 'NotFoundException')),
            'error'   => $this->_convertExceptionToArray($e),
        ], HTTP_NOT_FOUND);
    }

    /**
     * Return MethodNotAllowed Api response.
     * (Swagger Response: Responses.Api.Core.MethodNotAllowed)
     *
     * @param \Throwable|null $e          <p>Exception object.</p>
     * @param string|null     $message    <p>Error message (default: __('An exception, the method :attribute not found.')).</p>
     * @param bool            $useExsMess <p>Force use Exception's message (default: false).</p>
     * @return \Illuminate\Http\JsonResponse {"code": "METHOD_NOT_ALLOWED", "message": string, "type" => string, "error": ?array}
     */
    protected function methodNotAllowedApiResult(\Throwable $e = null, string $message = null, bool $useExsMess = false)
    {
        return $this->jsonResult([
            'code'    => ResponseConst::CODE_METHOD_NOT_ALLOWED,
            'message' => mb_trim($message ?: __('messages.error.method_not_allowed')),
            'type'    => $this->_getExceptionName($e, 'MethodNotAllowedHttpException'),
            'error'   => $this->_convertExceptionToArray($e),
        ], HTTP_METHOD_NOT_ALLOWED);
    }

    /**
     * Return UnprocessableEntity Api response.
     * (Swagger Response: Responses.Api.Core.UnprocessableEntity)
     *
     * @param string|null $code    <p>Error code    (default: 'UNPROCESSABLE_ENTITY').</p>
     * @param string|null $message <p>Error message (default: __('An exception, the entity cannot handle.')).</p>
     * @param string|null $type    <p>Type of Error (default: 'UnprocessableEntityException').</p>
     * @param array       $errors  <p>Detailed list of Errors.</p>
     * @return \Illuminate\Http\JsonResponse {"code": string, "message": string, "type" => string, "error": ?array}
     */
    protected function unprocessableEntityApiResult(string $code = null, string $message = null, string $type = null, array $errors = [])
    {
        return $this->jsonResult([
            'code'    => mb_trim($code ?: ResponseConst::CODE_UNPROCESSABLE_ENTITY),
            'message' => mb_trim($message ?: __('messages.error.unprocessable_entity')),
            'type'    => mb_trim($type ?: 'UnprocessableEntityException'),
            'error'   => $errors,
        ], HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Return Error Api response (Internal Server Error).
     * (Swagger Response: Responses.Api.Core.Error)
     *
     * @param \Throwable  $e          <p>Exception object.</p>
     * @param string|null $message    <p>Error message (default: __('An exception, internal server error - please contact technical department.')).</p>
     * @param bool        $useExsMess <p>Force use Exception's message (default: false).</p>
     * @return \Illuminate\Http\JsonResponse {"code": "INTERNAL_SERVER_ERROR", "message": string, "type" => string, "error": array}
     */
    protected function errorApiResult(\Throwable $e, string $message = null, bool $useExsMess = false)
    {
        return $this->jsonResult([
            'code'    => ResponseConst::CODE_INTERNAL_SERVER_ERROR,
            'message' => mb_trim($useExsMess ? $e->getMessage() : ($message ?: __('messages.error.internal_server_error'))),
            'type'    => mb_trim($this->_getExceptionName($e, 'ErrorException')),
            'error'   => $this->_convertExceptionToArray($e),
        ], HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Convert Exception to Array for Response.
     *
     * @param \Throwable|null $e <p>Exception object.</p>
     * @return array|null {exception, file, line, code, message}
     */
    private function _convertExceptionToArray(\Throwable $e = null): ?array
    {
        return is_null($e)
            ? null
            : array_merge(
                [
                    'exception' => get_class($e),
                    'file'      => $e->getFile(),
                    'line'      => $e->getLine(),
                    'code'      => $e->getCode(),
                    'message'   => $this->_getExceptionMessage($e),
                ],
                app_debug()
                    ? ['trace' => collect($e->getTrace())->map(fn($trace) => \Illuminate\Support\Arr::except($trace, ['args', 'type']))->all()]
                    : []
            );
    }

    /**
     * Get Exception message exclude Stack traces.
     *
     * @param \Throwable|null $e       <p>Exception object.</p>
     * @param string          $default <p>Default value for return: 'Exception'.</p>
     * @return string Exception message excluded Stack traces.
     */
    private function _getExceptionMessage(\Throwable $e = null, string $default = ''): string
    {
        if (empty($e)) {
            return $default;
        }
        $originMsg = $e->getMessage();
        $fillTrace = mb_strpos($originMsg, 'Stack trace:');
        return mb_trim(
            ($fillTrace !== false)
                ? mb_strcut($originMsg, 0, $fillTrace)
                : $originMsg
        );
    }

    /**
     * Get Exception Class name for Response.
     *
     * @param \Throwable|null $e       <p>Exception object.</p>
     * @param string          $default <p>Default value for return: 'Exception'.</p>
     * @return string The Exception Class name.
     */
    private function _getExceptionName(\Throwable $e = null, string $default = 'Exception'): string
    {
        $type = $e ? $e::class : $default;
        $types = explode('\\', $type);
        return count($types) ? $types[(count($types) - 1)] : $type;
    }
}
