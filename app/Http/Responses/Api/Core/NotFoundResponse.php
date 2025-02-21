<?php

namespace App\Http\Responses\Api\Core;

use OpenApi\Annotations as OA;

/**
 * @OA\Response(
 *      response="Responses.Api.Core.NotFound",
 *      description="Not Found response",
 *      @OA\JsonContent(ref="#/components/schemas/Resources.Api.Core.NotFound"),
 * )
 */
final class NotFoundResponse { }
