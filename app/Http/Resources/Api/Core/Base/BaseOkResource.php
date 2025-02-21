<?php

namespace App\Http\Resources\Api\Core\Base;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      schema="Resources.Api.Core.Base.Ok",
 *      title="Resources.Api.Core.Base.Ok",
 *      description="Successfully resource",
 *
 *      @OA\Property(
 *          property="code",
 *          type="string",
 *          example="OK",
 *          description="",
 *      ),
 *      @OA\Property(
 *          property="data",
 *          description="",
 *      ),
 *      @OA\Property(
 *          property="message",
 *          type="string",
 *          example="Success",
 *          description="",
 *      ),
 * )
 */
class BaseOkResource { }
