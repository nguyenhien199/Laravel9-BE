<?php

namespace App\Http\Parameters\Api\Core\Sorts;

use OpenApi\Annotations as OA;

/**
 * Parameter: The Sort type (in=query, required=true).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Core.Sorts.SortType.InQuery.Required",
 *      name="sort_type",
 *      in="query",
 *      required=true,
 *      @OA\Schema(
 *          type="string",
 *          maxLength=5,
 *          nullable=false,
 *          example="asc",
 *      ),
 *      description="The sort type in list [`asc`, `desc`]. <br/>Note: uppercase and lowercase allowed",
 * )
 * --------------------------------------------------
 * Parameter: The Sort type (in=query, required=false).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Core.Sorts.SortType.InQuery",
 *      name="sort_type",
 *      in="query",
 *      required=false,
 *      @OA\Schema(
 *          type="string",
 *          maxLength=5,
 *          nullable=true,
 *          example="asc",
 *          default="asc",
 *      ),
 *      description="The sort type in list [`asc`, `desc`]. <br/>If not, default is `asc`. <br/>Note: uppercase and lowercase allowed",
 * )
 */
final class SortTypeParameter { }
