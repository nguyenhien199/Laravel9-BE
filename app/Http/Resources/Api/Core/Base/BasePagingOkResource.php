<?php

namespace App\Http\Resources\Api\Core\Base;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      schema="Resources.Api.Core.Base.PagingOk",
 *      title="Resources.Api.Core.Base.PagingOk",
 *      description="Pagination successful resource",
 *
 *      allOf={
 *          @OA\Schema(ref="#/components/schemas/Resources.Api.Core.Base.Ok"),
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="data",
 *                  type="object",
 *                  @OA\Property(property="items", type="array", nullable=true, description="Returns a list of Resource objects",
 *                      @OA\Items(type="object")
 *                  ),
 *                  @OA\Property(property="pagination", type="object", nullable=false, description="Pagination object",
 *                      @OA\Property(property="current_page", type="integer", nullable=false, minimum=1, example=1, default=1, description="Current page"),
 *                      @OA\Property(property="from", type="integer", nullable=true, minimum=1, example=11, description="From item in total item"),
 *                      @OA\Property(property="last_page", type="integer", nullable=false, minimum=1, example=5, description="Last page number"),
 *                      @OA\Property(property="page_name", type="string", nullable=false, example="page", description="Page name"),
 *                      @OA\Property(property="path", type="string", nullable=false, example="https://example.com/api/users", description="Path url"),
 *                      @OA\Property(property="per_page", type="integer", nullable=false, minimum=1, example=10, description="Number item on page"),
 *                      @OA\Property(property="to", type="integer", nullable=true, minimum=1, example=20, description="To item in total item"),
 *                      @OA\Property(property="total", type="integer", nullable=false, minimum=0, example=45, description="Total item"),
 *                  ),
 *              )
 *          )
 *      }
 * )
 */
class BasePagingOkResource extends BaseOkResource { }
