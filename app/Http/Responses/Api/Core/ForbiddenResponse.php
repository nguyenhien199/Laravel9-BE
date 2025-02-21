<?php

namespace App\Http\Responses\Api\Core;

use OpenApi\Annotations as OA;

/**
 * @OA\Response(
 *      response="Responses.Api.Core.Forbidden",
 *      description="Forbidden response",
 *      @OA\JsonContent(ref="#/components/schemas/Resources.Api.Core.Forbidden"),
 * )
 */
final class ForbiddenResponse { }
