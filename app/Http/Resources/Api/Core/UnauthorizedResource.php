<?php

namespace App\Http\Resources\Api\Core;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      schema="Resources.Api.Core.Unauthorized",
 *      title="Resources.Api.Core.Unauthorized",
 *      description="Unauthorized resource",
 *
 *      @OA\Property(
 *          property="code",
 *          type="string",
 *          example="UNAUTHORIZED",
 *          description="",
 *      ),
 *      @OA\Property(
 *          property="message",
 *          type="string",
 *          example="An exception, failed authorization attempt",
 *          description="",
 *      ),
 *      @OA\Property(
 *          property="type",
 *          type="string",
 *          example="AuthorizationException",
 *          description="",
 *      ),
 * )
 */
final class UnauthorizedResource { }
