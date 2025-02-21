<?php

namespace App\Http\Responses\Api\Core\Exports;

use OpenApi\Annotations as OA;

/**
 * @OA\Response(
 *      response="Responses.Api.Core.Exports.PdfOk",
 *      description="Export PDF File successfully response",
 *      @OA\MediaType(
 *          mediaType="application/json, application/pdf",
 *          @OA\Schema(ref="#/components/schemas/Resources.Api.Core.Exports.PdfOk"),
 *      ),
 * )
 */
final class PdfOkResponse { }
