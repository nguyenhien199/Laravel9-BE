<?php

namespace App\Http\Parameters\Api\Share\Users;

/**
 * Parameter: User gender (in=query, required=true).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Share.Users.Gender.InQuery.Required",
 *      name="gender",
 *      in="query",
 *      required=true,
 *      @OA\Schema(
 *          type="integer",
 *          minimum=0,
 *          maximum=2,
 *          nullable=false,
 *          example="1",
 *      ),
 *      description="User gender. <br/>In list [`0`: OTHER, `1`: MALE, `2`: FEMALE].",
 * )
 * --------------------------------------------------
 * Parameter: User gender (in=query, required=false).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Share.Users.Gender.InQuery",
 *      name="gender",
 *      in="query",
 *      required=false,
 *      @OA\Schema(
 *          type="integer",
 *          minimum=0,
 *          maximum=2,
 *          nullable=true,
 *          example="",
 *          default="null",
 *      ),
 *      description="User gender. <br/>In list [`null`: get all, `0`: OTHER, `1`: MALE, `2`: FEMALE]. <br/>If not, default is `null`.",
 * )
 */
final class UserGenderParameter { }
