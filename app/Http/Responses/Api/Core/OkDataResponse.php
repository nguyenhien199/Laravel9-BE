<?php

namespace App\Http\Responses\Api\Core;

use OpenApi\Annotations as OA;

/**
 * @OA\Response(
 *      response="Responses.Api.Core.OkData",
 *      description="Successfully response",
 *      @OA\JsonContent(ref="#/components/schemas/Resources.Api.Core.OkData"),
 * )
 */
final class OkDataResponse { }
