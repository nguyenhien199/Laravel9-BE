<?php

namespace App\Http\Responses\Api\Admin\Users;

use OpenApi\Annotations as OA;

/**
 * @OA\Response(
 *      response="Responses.Api.Admin.Users.PaginateOk",
 *      description="Successfully response",
 *      @OA\JsonContent(
 *          allOf={
 *              @OA\Schema(ref="#/components/schemas/Resources.Api.Core.Base.PagingOk"),
 *              @OA\Schema(
 *                  @OA\Property(
 *                      property="data",
 *                      type="object",
 *                      @OA\Property(property="items",type="array",
 *                          @OA\Items(ref="#/components/schemas/Resources.Api.Admin.User")
 *                      ),
 *                      @OA\Property(property="pagination",type="object",
 *                           @OA\Property(property="path", type="string", nullable=false, example="https://example.com/api/admin/user", description="Path url")
 *                      )
 *                  )
 *              )
 *          }
 *      )
 * )
 */
final class UserPaginateOkApiAdminResponse { }