<?php

namespace App\Http\Parameters\Api\Core\Tokens;

use OpenApi\Annotations as OA;

/**
 * Parameter: The API Token (in=query, required=true).
 * @OA\Parameter(
 *     parameter="Parameters.Api.Core.Tokens.ApiToken.InQuery.Required",
 *     name="api_token",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *          type="string",
 *          pattern="^[a-zA-Z0-9]+$",
 *          nullable=false,
 *          example="Nh6GYyN79QEejdU4lPfHvw0gOUfmtanhSCNcGI2q",
 *     ),
 *     description="The Api Token.",
 * )
 * --------------------------------------------------
 * Parameter: The API Token (in=query, required=false).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Core.Tokens.ApiToken.InQuery",
 *      name="api_token",
 *      in="query",
 *      required=false,
 *      @OA\Schema(
 *          type="string",
 *          pattern="^[a-zA-Z0-9]+$",
 *          nullable=true,
 *          example="Nh6GYyN79QEejdU4lPfHvw0gOUfmtanhSCNcGI2q",
 *          default="null",
 *      ),
 *      description="The Api Token. <br/>If not, default is `null`.",
 * )
 */
final class ApiTokenParameter { }
