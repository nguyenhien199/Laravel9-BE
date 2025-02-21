<?php

namespace App\Http\Resources\Api\Core;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      schema="Resources.Api.Core.Forbidden",
 *      title="Resources.Api.Core.Forbidden",
 *      description="Forbidden resource",
 *
 *      @OA\Property(
 *          property="code",
 *          type="string",
 *          example="FORBIDDEN",
 *          description="",
 *      ),
 *      @OA\Property(
 *          property="message",
 *          type="string",
 *          example="You don't have permission to access",
 *          description="",
 *      ),
 *      @OA\Property(
 *          property="type",
 *          type="string",
 *          example="ForbiddenException",
 *          description="",
 *      ),
 * )
 */
final class ForbiddenResource { }
