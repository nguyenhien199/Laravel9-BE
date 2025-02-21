<?php

namespace App\Http\Resources\Api\Core;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      schema="Resources.Api.Core.BadRequest",
 *      title="Resources.Api.Core.BadRequest",
 *      description="Bad Request resource",
 *
 *      @OA\Property(
 *          property="code",
 *          type="string",
 *          example="BAD_REQUEST",
 *          description="",
 *      ),
 *      @OA\Property(
 *          property="message",
 *          type="string",
 *          example="A bad request, please try again",
 *          description="",
 *      ),
 *      @OA\Property(
 *          property="type",
 *          type="string",
 *          example="BadRequestException",
 *          description="",
 *      ),
 * )
 */
final class BadRequestResource { }
