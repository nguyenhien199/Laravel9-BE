<?php

namespace App\Http\Responses\Api\Core;

use OpenApi\Annotations as OA;

/**
 * @OA\Response(
 *      response="Responses.Api.Core.BadRequest",
 *      description="Bad Request response",
 *      @OA\JsonContent(ref="#/components/schemas/Resources.Api.Core.BadRequest"),
 * )
 */
final class BadRequestResponse { }
