<?php

namespace App\Http\Responses\Api\Core\Exports;

use OpenApi\Annotations as OA;

/**
 * @OA\Response(
 *      response="Responses.Api.Core.Exports.ExcelOk",
 *      description="Export EXCEL File successfully response",
 *      @OA\MediaType(
 *          mediaType="application/json, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
 *          @OA\Schema(ref="#/components/schemas/Resources.Api.Core.Exports.ExcelOk"),
 *      ),
 * )
 */
final class ExcelOkResponse { }
