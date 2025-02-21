<?php

namespace App\Http\Responses\Api\Admin\Users\Profiles;

use OpenApi\Annotations as OA;

/**
 * @OA\Response(
 *      response="Responses.Api.Admin.Users.Profiles.InfoOk",
 *      description="Successfully response",
 *      @OA\JsonContent(
 *          allOf={
 *              @OA\Schema(ref="#/components/schemas/Resources.Api.Core.Base.Ok"),
 *              @OA\Schema(
 *                  @OA\Property(property="data", ref="#/components/schemas/Resources.Api.Admin.User")
 *              )
 *          }
 *      )
 * )
 */
final class UserProfileInfoOkApiAdminResponse { }
