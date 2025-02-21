<?php

namespace App\Http\Responses\Api\Core;

use OpenApi\Annotations as OA;

/**
 * @OA\Response(
 *      response="Responses.Api.Core.Error",
 *      description="Internal Server Error response",
 *      @OA\JsonContent(ref="#/components/schemas/Resources.Api.Core.Error"),
 * )
 */
final class ErrorResponse { }
