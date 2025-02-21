<?php

namespace App\Http\Parameters\Api\Core\Paginate;

use OpenApi\Annotations as OA;

/**
 * Parameter: Page number (in=query, required=true).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Core.Paginate.Page.InQuery.Required",
 *      name="page",
 *      in="query",
 *      required=true,
 *      @OA\Schema(
 *          type="integer",
 *          minimum=1,
 *          nullable=false,
 *          example=1,
 *      ),
 *      description="Page number."
 * )
 * --------------------------------------------------
 * Parameter: Page number (in=query, required=false).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Core.Paginate.Page.InQuery",
 *      name="page",
 *      in="query",
 *      required=false,
 *      @OA\Schema(
 *          type="integer",
 *          minimum=1,
 *          nullable=true,
 *          example=1,
 *          default=1,
 *      ),
 *      description="Page number. <br/>If not, default is `1`."
 * )
 */
final class PageParameter { }
