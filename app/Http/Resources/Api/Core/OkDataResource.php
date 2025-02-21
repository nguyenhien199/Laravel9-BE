<?php

namespace App\Http\Resources\Api\Core;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      schema="Resources.Api.Core.OkData",
 *      title="Resources.Api.Core.OkData",
 *      description="Successfully resource",
 *
 *      allOf={
 *          @OA\Schema(ref="#/components/schemas/Resources.Api.Core.Base.Ok"),
 *          @OA\Schema(
 *              @OA\Property(
 *                  property="data",
 *                  anyOf={
 *                      @OA\Schema(type="boolean", description="Return `boolean` type", example="true"),
 *                      @OA\Schema(type="integer", description="Return `integer` type", example=1234),
 *                      @OA\Schema(type="string", description="Return `string` type", example="string data"),
 *                      @OA\Schema(type="object", description="Return `object` type", example={"id": 1, "name":"item1"}),
 *                      @OA\Schema(type="array", description="Return `list` type", @OA\Items(type="object", example={{"id": 1, "name":"item1"}, {"id": 2, "name":"item2"}})),
 *                  },
 *              ),
 *          ),
 *      },
 * )
 */
final class OkDataResource extends Base\BaseOkResource { }
