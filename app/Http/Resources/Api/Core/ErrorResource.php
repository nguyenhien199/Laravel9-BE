<?php

namespace App\Http\Resources\Api\Core;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      schema="Resources.Api.Core.Error",
 *      title="Resources.Api.Core.Error",
 *      description="Internal Server Error resource",
 *
 *      @OA\Property(
 *          property="code",
 *          type="string",
 *          example="INTERNAL_SERVER_ERROR",
 *          description="",
 *      ),
 *      @OA\Property(
 *          property="message",
 *          type="string",
 *          example="An exception, Please contact technical department",
 *          description="",
 *      ),
 *      @OA\Property(
 *          property="type",
 *          type="string",
 *          example="ErrorException",
 *          description="",
 *      ),
 *      @OA\Property(
 *          property="errors",
 *          type="object",
 *          nullable=true,
 *          example={
 *              "class": "ErrorException",
 *              "file": "App\Exceptions\ErrorException",
 *              "line": "231",
 *              "code": "0",
 *              "msg": "An Exception, ..."
 *          },
 *          description="",
 *      ),
 * )
 */
final class ErrorResource { }
