<?php

namespace App\Http\Parameters\Api\Share\Users;

/**
 * Parameter: User status (in=query, required=true).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Share.Users.Status.InQuery.Required",
 *      name="status",
 *      in="query",
 *      required=true,
 *      @OA\Schema(
 *          type="integer",
 *          minimum=0,
 *          maximum=1,
 *          nullable=false,
 *          example="1",
 *      ),
 *      description="User status. <br/>In list [`1` is active, `0` inactive].",
 * )
 * --------------------------------------------------
 * Parameter: User status (in=query, required=false).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Share.Users.Status.InQuery",
 *      name="status",
 *      in="query",
 *      required=false,
 *      @OA\Schema(
 *          type="integer",
 *          minimum=0,
 *          maximum=1,
 *          nullable=true,
 *          example="",
 *          default="null",
 *      ),
 *      description="User status. <br/>In list [`null` get all, `1` is active, `0` inactive]. <br/>If not, default is `null`.",
 * )
 */
final class UserStatusParameter { }
