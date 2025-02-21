<?php

namespace App\Http\Resources\Api\Core;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      schema="Resources.Api.Core.MethodNotAllowed",
 *      title="Resources.Api.Core.MethodNotAllowed",
 *      description="Method Not Allowed resource",
 *
 *      @OA\Property(
 *          property="code",
 *          type="string",
 *          example="METHOD_NOT_ALLOWED",
 *          description="",
 *      ),
 *      @OA\Property(
 *          property="message",
 *          type="string",
 *          example="An exception, The request method is not supported by the system",
 *          description="",
 *      ),
 *      @OA\Property(
 *          property="type",
 *          type="string",
 *          example="MethodNotAllowedHttpException",
 *          description="",
 *      ),
 *      @OA\Property(
 *          property="errors",
 *          type="object",
 *          nullable=true,
 *          example={
 *              "class": "MethodNotAllowedHttpException",
 *              "file": "App\Exceptions\MethodNotAllowedHttpException",
 *              "line": "231",
 *              "code": "0",
 *              "msg": "An Exception, ..."
 *          },
 *          description="",
 *      ),
 * )
 */
final class MethodNotAllowedResource { }
