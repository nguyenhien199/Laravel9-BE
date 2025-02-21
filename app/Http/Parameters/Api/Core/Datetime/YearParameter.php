<?php

namespace App\Http\Parameters\Api\Core\Datetime;

use OpenApi\Annotations as OA;

/**
 * Parameter: Year number (in=path, required=true).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Core.Datetime.Year.InPath.Required",
 *      name="year",
 *      in="path",
 *      required=true,
 *      @OA\Schema(
 *          type="integer",
 *          minimum=1970,
 *          maximum=9999,
 *          nullable=false,
 *          example=2023,
 *      ),
 *      description="Year number. <br/>Format: `yyyy`."
 * )
 * --------------------------------------------------
 * Parameter: Year number (in=path, required=false).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Core.Datetime.Year.InPath",
 *      name="year",
 *      in="path",
 *      required=false,
 *      @OA\Schema(
 *          type="integer",
 *          minimum=1970,
 *          maximum=9999,
 *          nullable=true,
 *          example=2023,
 *          default="null",
 *      ),
 *      description="Year number. <br/>Format: `yyyy`. <br/>If not, default is `null`."
 * )
 * --------------------------------------------------
 * Parameter: Year number (in=query, required=true).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Core.Datetime.Year.InQuery.Required",
 *      name="year",
 *      in="query",
 *      required=true,
 *      @OA\Schema(
 *          type="integer",
 *          minimum=1970,
 *          maximum=9999,
 *          nullable=false,
 *          example=2023,
 *      ),
 *      description="Year number. <br/>Format: `yyyy`."
 * )
 * --------------------------------------------------
 * Parameter: Year number (in=query, required=false).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Core.Datetime.Year.InQuery",
 *      name="year",
 *      in="query",
 *      required=false,
 *      @OA\Schema(
 *          type="integer",
 *          minimum=1970,
 *          maximum=9999,
 *          nullable=true,
 *          example=2023,
 *          default="null",
 *      ),
 *      description="Year number. <br/>Format: `yyyy`. <br/>If not, default is `null`."
 * )
 */
final class YearParameter { }
