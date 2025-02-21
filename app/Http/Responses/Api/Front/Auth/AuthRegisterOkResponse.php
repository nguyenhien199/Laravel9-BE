<?php

namespace App\Http\Responses\Api\Front\Auth;

use OpenApi\Annotations as OA;

/**
 * @OA\Response(
 *      response="Responses.Api.Front.Auth.RegisterOk",
 *      description="Successfully response",
 *      @OA\JsonContent(
 *          allOf={
 *              @OA\Schema(ref="#/components/schemas/Resources.Api.Core.Base.Ok"),
 *              @OA\Schema(
 *                  @OA\Property(property="data", ref="#/components/schemas/Resources.Api.Front.User")
 *              ),
 *          },
 *      ),
 * )
 */
final class AuthRegisterOkResponse { }
