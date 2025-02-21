<?php

namespace App\Http\Responses\Api\Core;

use OpenApi\Annotations as OA;

/**
 * @OA\Response(
 *      response="Responses.Api.Core.Unauthorized",
 *      description="Unauthorized response <br/>(Code: UNAUTHORIZED: failed authorization / TOKEN_EXPIRED: token has expired)",
 *      @OA\JsonContent(ref="#/components/schemas/Resources.Api.Core.Unauthorized"),
 * )
 */
final class UnauthorizedResponse { }
