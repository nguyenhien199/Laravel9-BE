<?php

namespace App\Http\Resources\Api\Core;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      schema="Resources.Api.Core.NotFound",
 *      title="Resources.Api.Core.NotFound",
 *      description="Not Found resource",
 *
 *      @OA\Property(
 *          property="code",
 *          type="string",
 *          example="NOT_FOUND",
 *          description="",
 *      ),
 *      @OA\Property(
 *          property="message",
 *          type="string",
 *          example="The Resource you are looking for is not available",
 *          description="",
 *      ),
 *      @OA\Property(
 *          property="type",
 *          type="string",
 *          example="NotFoundException",
 *          description="",
 *      ),
 *      @OA\Property(
 *          property="errors",
 *          type="object",
 *          nullable=true,
 *          example={
 *              "class": "NotFoundException",
 *              "file": "App\Exceptions\NotFoundException",
 *              "line": "231",
 *              "code": "0",
 *              "msg": "An Exception, ..."
 *          },
 *          description="",
 *      ),
 * )
 */
final class NotFoundResource { }
