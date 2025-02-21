<?php

namespace App\Http\Parameters\Api\Core\Datetime;

use OpenApi\Annotations as OA;

/**
 * Parameter: Month number (in=path, required=true).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Core.Datetime.Month.InPath.Required",
 *      name="month",
 *      in="path",
 *      required=true,
 *      @OA\Schema(
 *          type="integer",
 *          minimum=1,
 *          maximum=12,
 *          nullable=false,
 *          example=6,
 *      ),
 *      description="Month number. <br/>Format: `mm`|`m`."
 * )
 * --------------------------------------------------
 * Parameter: Month number (in=path, required=false).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Core.Datetime.Month.InPath",
 *      name="month",
 *      in="path",
 *      required=false,
 *      @OA\Schema(
 *          type="integer",
 *          minimum=1,
 *          maximum=12,
 *          nullable=true,
 *          example=6,
 *          default="null",
 *      ),
 *      description="Month number. <br/>Format: `mm`|`m`. <br/>If not, default is `null`."
 * )
 * --------------------------------------------------
 * Parameter: Month number (in=query, required=true).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Core.Datetime.Month.InQuery.Required",
 *      name="month",
 *      in="query",
 *      required=true,
 *      @OA\Schema(
 *          type="integer",
 *          minimum=1,
 *          maximum=12,
 *          nullable=false,
 *          example=6,
 *      ),
 *      description="Month number. <br/>Format: `mm`|`m`."
 * )
 * --------------------------------------------------
 * Parameter: Month number (in=query, required=false).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Core.Datetime.Month.InQuery",
 *      name="month",
 *      in="query",
 *      required=false,
 *      @OA\Schema(
 *          type="integer",
 *          minimum=1,
 *          maximum=12,
 *          nullable=true,
 *          example=6,
 *          default="null",
 *      ),
 *      description="Month number. <br/>Format: `mm`|`m`. <br/>If not, default is `null`."
 * )
 */
final class MonthParameter { }
