<?php

namespace App\Http\Parameters\Api\Share\Users;

/**
 * Parameter: User ID number (in=path, required=true).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Share.Users.Id.InPath.Required",
 *      name="userId",
 *      in="path",
 *      required=true,
 *      @OA\Schema(
 *          type="integer",
 *          minimum=1,
 *          maxLength=20,
 *          nullable=false,
 *          example="",
 *      ),
 *      description="User ID number",
 * )
 * --------------------------------------------------
 * Parameter: User ID number (in=path, required=false).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Share.Users.Id.InPath",
 *      name="userId",
 *      in="path",
 *      required=true,
 *      @OA\Schema(
 *          type="integer",
 *          minimum=1,
 *          maxLength=20,
 *          nullable=false,
 *          example="",
 *          default="null",
 *      ),
 *      description="User ID number. <br/>If not, default is `null`.",
 * )
 * --------------------------------------------------
 * Parameter: User ID number (in=query, required=true).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Share.Users.Id.InQuery.Required",
 *      name="user_id",
 *      in="query",
 *      required=true,
 *      @OA\Schema(
 *          type="integer",
 *          minimum=1,
 *          maxLength=20,
 *          nullable=false,
 *          example="",
 *      ),
 *      description="User ID number.",
 * )
 * --------------------------------------------------
 * Parameter: User ID number (in=query, required=false).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Share.Users.Id.InQuery",
 *      name="user_id",
 *      in="query",
 *      required=false,
 *      @OA\Schema(
 *          type="integer",
 *          minimum=1,
 *          maxLength=20,
 *          nullable=true,
 *          example="",
 *          default="null",
 *      ),
 *      description="User ID number. <br/>If not, default is `null`.",
 * )
 */
final class UserIdParameter { }
