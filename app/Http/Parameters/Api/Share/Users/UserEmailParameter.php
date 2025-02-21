<?php

namespace App\Http\Parameters\Api\Share\Users;

/**
 * Parameter: User email (in=query, required=true).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Share.Users.Email.InQuery.Required",
 *      name="email",
 *      in="query",
 *      required=true,
 *      @OA\Schema(
 *          type="string",
 *          maxLength=100,
 *          nullable=false,
 *          example="",
 *      ),
 *      description="User email.",
 * )
 * --------------------------------------------------
 * Parameter: User email (in=query, required=false).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Share.Users.Email.InQuery",
 *      name="email",
 *      in="query",
 *      required=false,
 *      @OA\Schema(
 *          type="string",
 *          maxLength=100,
 *          nullable=true,
 *          example="",
 *          default="null",
 *      ),
 *      description="User email. <br/>If not, default is `null`.",
 * )
 */
final class UserEmailParameter { }
