<?php

namespace App\Http\Parameters\Api\Core\Sorts;

use OpenApi\Annotations as OA;

/**
 * Parameter: The Sort field (in=query, required=true).
 * @OA\Parameter(
 *     parameter="Parameters.Api.Core.Sorts.SortField.InQuery.Required",
 *     name="sort",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *          type="string",
 *          maxLength=100,
 *          nullable=false,
 *          example="id",
 *     ),
 *     description="Sort field in list [`id`]. <br/>Note: uppercase and lowercase allowed",
 * )
 * --------------------------------------------------
 * Parameter: The Sort field (in=query, required=false).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Core.Sorts.SortField.InQuery",
 *      name="sort",
 *      in="query",
 *      required=false,
 *      @OA\Schema(
 *          type="string",
 *          maxLength=100,
 *          nullable=true,
 *          example="id",
 *          default="id",
 *      ),
 *      description="Sort field in list [`id`]. <br/>If not, default is `id`. <br/>Note: uppercase and lowercase allowed",
 * )
 */
final class SortFieldParameter { }
