<?php

namespace App\Http\Resources\Api\Core;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      schema="Resources.Api.Core.UnprocessableEntity",
 *      title="Resources.Api.Core.UnprocessableEntity",
 *      description="Unprocessable Entity resource",
 *
 *      @OA\Property(
 *          property="code",
 *          type="string",
 *          example="FAILED_VALIDATION",
 *          description="",
 *      ),
 *      @OA\Property(
 *          property="message",
 *          type="string",
 *          example="An exception, failed validation attempt",
 *          description="",
 *      ),
 *      @OA\Property(
 *          property="type",
 *          type="string",
 *          example="ValidationException",
 *          description="",
 *      ),
 *      @OA\Property(
 *          property="errors",
 *          type="object",
 *          nullable=true,
 *          example={
 *              "name": {
 *                  "name is required",
 *                  "Minimum length 6 characters"
 *              },
 *              "email": {
 *                  "email is required"
 *              }
 *          },
 *          description="",
 *      ),
 * )
 */
final class UnprocessableEntityResource { }
