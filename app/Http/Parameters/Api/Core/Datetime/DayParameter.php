<?php

namespace App\Http\Parameters\Api\Core\Datetime;

use OpenApi\Annotations as OA;

/**
 * Parameter: Day number (in=path, required=true).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Core.Datetime.Day.InPath.Required",
 *      name="day",
 *      in="path",
 *      required=true,
 *      @OA\Schema(
 *          type="integer",
 *          minimum=1,
 *          maximum=31,
 *          nullable=false,
 *          example=6,
 *      ),
 *      description="Day number. <br/>Format: `dd`|`d`."
 * )
 * --------------------------------------------------
 * Parameter: Day number (in=path, required=false).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Core.Datetime.Day.InPath",
 *      name="day",
 *      in="path",
 *      required=false,
 *      @OA\Schema(
 *          type="integer",
 *          minimum=1,
 *          maximum=31,
 *          nullable=true,
 *          example=6,
 *          default="null",
 *      ),
 *      description="Day number. <br/>Format: `dd`|`d`. <br/>If not, default is `null`."
 * )
 * --------------------------------------------------
 * Parameter: Day number (in=query, required=true).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Core.Datetime.Day.InQuery.Required",
 *      name="day",
 *      in="query",
 *      required=true,
 *      @OA\Schema(
 *          type="integer",
 *          minimum=1,
 *          maximum=31,
 *          nullable=false,
 *          example=6,
 *      ),
 *      description="Day number. <br/>Format: `dd`|`d`."
 * )
 * --------------------------------------------------
 * Parameter: Day number (in=query, required=false).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Core.Datetime.Day.InQuery",
 *      name="day",
 *      in="query",
 *      required=false,
 *      @OA\Schema(
 *          type="integer",
 *          minimum=1,
 *          maximum=31,
 *          nullable=true,
 *          example=6,
 *          default="null",
 *      ),
 *      description="Day number. <br/>Format: `dd`|`d`. <br/>If not, default is `null`."
 * )
 */
final class DayParameter { }
