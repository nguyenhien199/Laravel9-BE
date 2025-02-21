<?php

namespace App\Http\Parameters\Api\Core\Locale;

use OpenApi\Annotations as OA;

/**
 * Parameter: Translate to language (in=header, required=false).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Core.Locale.Lang.InHeader",
 *      name="X-LANG",
 *      in="header",
 *      required=false,
 *      @OA\Schema(
 *          type="string",
 *          maxLength=20,
 *          nullable=true,
 *          example="en",
 *          default="null",
 *      ),
 *      description="Translate to language. <br/>Example: `en` or `ja`. <br/>If not, default is `null`. <br/>Note: uppercase and lowercase allowed.",
 * )
 * --------------------------------------------------
 * Parameter: Translate to language (in=query, required=true).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Core.Locale.Lang.InQuery.Required",
 *      name="lang",
 *      in="query",
 *      required=true,
 *      @OA\Schema(
 *          type="string",
 *          maxLength=20,
 *          nullable=false,
 *          example="en",
 *      ),
 *      description="Translate to language. <br/>Example: `en` or `ja`. <br/>Note: uppercase and lowercase allowed."
 * )
 * --------------------------------------------------
 * Parameter: Translate to language (in=query, required=false).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Core.Locale.Lang.InQuery",
 *      name="lang",
 *      in="query",
 *      required=false,
 *      @OA\Schema(
 *          type="string",
 *          maxLength=20,
 *          nullable=true,
 *          example="ja",
 *          default="null",
 *      ),
 *      description="Translate to language. <br/>Example: `en` or `ja`. <br/>If not, default is `null`. <br/>Note: uppercase and lowercase allowed."
 * )
 */
final class LangParameter { }
