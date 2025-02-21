<?php

namespace App\Http\Responses\Api\Core;

use OpenApi\Annotations as OA;

/**
 * @OA\Response(
 *      response="Responses.Api.Core.UnprocessableEntity",
 *      description="Unprocessable Entity response",
 *      @OA\JsonContent(ref="#/components/schemas/Resources.Api.Core.UnprocessableEntity"),
 * )
 */
final class UnprocessableEntityResponse { }
