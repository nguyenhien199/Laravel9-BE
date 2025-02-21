<?php

namespace App\Http\Responses\Api\Share\Auth;

use OpenApi\Annotations as OA;

/**
 * @OA\Response(
 *      response="Responses.Api.Share.Auth.RefreshOk",
 *      description="Successfully response",
 *      @OA\JsonContent(
 *          allOf={
 *              @OA\Schema(ref="#/components/schemas/Resources.Api.Core.Base.Ok"),
 *              @OA\Schema(
 *                  @OA\Property(property="data", ref="#/components/schemas/Resources.Api.Share.Auth.Login")
 *              )
 *          }
 *      )
 * )
 */
final class AuthRefreshOkResponse { }
