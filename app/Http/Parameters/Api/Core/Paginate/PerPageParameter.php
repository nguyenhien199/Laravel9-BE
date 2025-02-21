<?php

namespace App\Http\Parameters\Api\Core\Paginate;

use OpenApi\Annotations as OA;

/**
 * Parameter: Per Page number (in=query, required=true).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Core.Paginate.PerPage.InQuery.Required",
 *      name="per_page",
 *      in="query",
 *      required=true,
 *      @OA\Schema(
 *          type="integer",
 *          minimum=1,
 *          maximum=100,
 *          nullable=false,
 *          example=20,
 *      ),
 *      description="The number of items to return. <br/>Suggested in the list [`10`, `15`, `20`, `50`, `100`]. <br/>The maximum limit: `100`."
 * )
 * --------------------------------------------------
 * Parameter: Per Page number (in=query, required=false).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Core.Paginate.PerPage.InQuery",
 *      name="per_page",
 *      in="query",
 *      required=false,
 *      @OA\Schema(
 *          type="integer",
 *          minimum=1,
 *          maximum=100,
 *          nullable=true,
 *          example=20,
 *          default=20,
 *      ),
 *      description="The number of items to return. <br/>Suggested in the list [`10`, `15`, `20`, `50`, `100`]. <br/>The maximum limit: `100`. <br/>If not, default is `20`."
 * )
 */
final class PerPageParameter { }
