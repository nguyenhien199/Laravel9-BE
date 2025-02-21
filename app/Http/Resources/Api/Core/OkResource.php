<?php

namespace App\Http\Resources\Api\Core;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      schema="Resources.Api.Core.Ok",
 *      title="Resources.Api.Core.Ok",
 *      description="Successfully resource",
 *
 *      allOf={
 *          @OA\Schema(ref="#/components/schemas/Resources.Api.Core.Base.Ok"),
 *          @OA\Schema(
 *              @OA\Property(property="data", type="array", @OA\Items(type="null"), maxItems=0, example={}, description=""),
 *          ),
 *      },
 * )
 */
final class OkResource extends Base\BaseOkResource { }
