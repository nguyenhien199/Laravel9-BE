<?php

namespace App\Http\Parameters\Api\Core\Exports;

use OpenApi\Annotations as OA;

/**
 * Parameter: The export File type (in=query, required=true).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Core.Exports.ExportType.InQuery.Required",
 *      name="export_type",
 *      in="query",
 *      required=true,
 *      @OA\Schema(
 *          type="string",
 *          minLength=1,
 *          maxLength=20,
 *          nullable=false,
 *          example="xlsx",
 *      ),
 *      description="Export file type in list [`xlsx`, `pdf`, `csv`]. <br/>Note: uppercase and lowercase allowed",
 * )
 */
final class ExportTypeParameter { }
