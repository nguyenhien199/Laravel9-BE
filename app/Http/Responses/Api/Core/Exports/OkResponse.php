<?php

namespace App\Http\Responses\Api\Core\Exports;

use OpenApi\Annotations as OA;

/**
 * @OA\Response(
 *      response="Responses.Api.Core.Exports.Ok",
 *      description="Export File successfully response",
 *      @OA\MediaType(
 *          mediaType="application/json, application/pdf, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, text/html, text/csv, text/plain",
 *          @OA\Schema(ref="#/components/schemas/Resources.Api.Core.Exports.Ok"),
 *      ),
 * )
 */
final class OkResponse { }
