<?php

namespace App\Http\Responses\Api\Core;

use OpenApi\Annotations as OA;

/**
 * @OA\Response(
 *      response="Responses.Api.Core.Ok",
 *      description="Successfully response",
 *      @OA\JsonContent(ref="#/components/schemas/Resources.Api.Core.Ok"),
 * )
 */
final class OkResponse { }
