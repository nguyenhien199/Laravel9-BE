<?php

namespace App\Http\Responses\Api\Core;

use OpenApi\Annotations as OA;

/**
 * @OA\Response(
 *      response="Responses.Api.Core.MethodNotAllowed",
 *      description="Method Not Allowed response",
 *      @OA\JsonContent(ref="#/components/schemas/Resources.Api.Core.MethodNotAllowed"),
 * )
 */
final class MethodNotAllowedResponse { }
