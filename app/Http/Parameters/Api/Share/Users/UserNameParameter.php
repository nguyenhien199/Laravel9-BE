<?php

namespace App\Http\Parameters\Api\Share\Users;

/**
 * Parameter: User Full name (in=query, required=true).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Share.Users.FullName.InQuery.Required",
 *      name="full_name",
 *      in="query",
 *      required=true,
 *      @OA\Schema(
 *          type="string",
 *          maxLength=100,
 *          nullable=false,
 *          example="",
 *      ),
 *      description="User Full Name.",
 * )
 * --------------------------------------------------
 * Parameter: User Full name (in=query, required=false).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Share.Users.FullName.InQuery",
 *      name="full_name",
 *      in="query",
 *      required=true,
 *      @OA\Schema(
 *          type="string",
 *          maxLength=100,
 *          nullable=true,
 *          example="",
 *          default="null",
 *      ),
 *      description="User fullname. <br/>If not, default is `null`.",
 * )
 * --------------------------------------------------
 * Parameter: User Firstname (in=query, required=true).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Share.Users.Firstname.InQuery.Required",
 *      name="firstname",
 *      in="query",
 *      required=true,
 *      @OA\Schema(
 *          type="string",
 *          maxLength=100,
 *          nullable=false,
 *          example="",
 *      ),
 *      description="User firstname.",
 * )
 * --------------------------------------------------
 * Parameter: User Firstname (in=query, required=false).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Share.Users.Firstname.InQuery",
 *      name="firstname",
 *      in="query",
 *      required=false,
 *      @OA\Schema(
 *          type="string",
 *          maxLength=100,
 *          nullable=true,
 *          example="",
 *          default="null",
 *      ),
 *      description="User firstname. <br/>If not, default is `null`.",
 * )
 * --------------------------------------------------
 * Parameter: User Lastname (in=query, required=true).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Share.Users.Lastname.InQuery.Required",
 *      name="lastname",
 *      in="query",
 *      required=true,
 *      @OA\Schema(
 *          type="string",
 *          maxLength=100,
 *          nullable=false,
 *          example="",
 *      ),
 *      description="User lastname.",
 * )
 * --------------------------------------------------
 * Parameter: User Lastname (in=query, required=false).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Share.Users.Lastname.InQuery",
 *      name="lastname",
 *      in="query",
 *      required=false,
 *      @OA\Schema(
 *          type="string",
 *          maxLength=100,
 *          nullable=true,
 *          example="",
 *          default="null",
 *      ),
 *      description="User lastname. <br/>If not, default is `null`.",
 * )
 */
final class UserNameParameter { }
