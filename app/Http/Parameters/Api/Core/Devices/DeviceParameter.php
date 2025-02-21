<?php

namespace App\Http\Parameters\Api\Core\Devices;

use OpenApi\Annotations as OA;

/**
 * Parameter: Device ID (in=header, required=false).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Share.Devices.DeviceId.InHeader",
 *      name="X-DEVICE-ID",
 *      in="header",
 *      required=false,
 *      @OA\Schema(
 *          type="string",
 *          maxLength=100,
 *          nullable=true,
 *          example="1546058f-5a25-4334-85ae-e68f2a44bbaf",
 *          default="null",
 *      ),
 *      description="Device ID. <br/>If not, default is `null`.",
 * )
 * --------------------------------------------------
 * Parameter: Device Type (in=header, required=false).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Share.Devices.Type.InHeader",
 *      name="X-DEVICE-TYPE",
 *      in="header",
 *      required=false,
 *      @OA\Schema(
 *          type="string",
 *          maxLength=100,
 *          nullable=true,
 *          example="Mobile",
 *          default="null",
 *      ),
 *      description="Device Type. <br/>If not, default is `null`.",
 * )
 * --------------------------------------------------
 * Parameter: Device Name (in=header, required=false).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Share.Devices.Name.InHeader",
 *      name="X-DEVICE-NAME",
 *      in="header",
 *      required=false,
 *      @OA\Schema(
 *          type="string",
 *          maxLength=255,
 *          nullable=true,
 *          example="Samsung Glaxy Note9",
 *          default="null",
 *      ),
 *      description="Device Name. <br/>If not, default is `null`.",
 * )
 * --------------------------------------------------
 * Parameter: Device Token (in=header, required=false).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Share.Devices.Token.InHeader",
 *      name="X-DEVICE-TOKEN",
 *      in="header",
 *      required=false,
 *      @OA\Schema(
 *          type="string",
 *          maxLength=255,
 *          nullable=true,
 *          example="",
 *          default="null",
 *      ),
 *      description="Device Token. <br/>If not, default is `null`.",
 * )
 * --------------------------------------------------
 * Parameter: Device System Name (in=header, required=false).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Share.Devices.SystemName.InHeader",
 *      name="X-SYSTEM-NAME",
 *      in="header",
 *      required=false,
 *      @OA\Schema(
 *          type="string",
 *          maxLength=255,
 *          nullable=true,
 *          example="Android",
 *          default="null",
 *      ),
 *      description="System Name of the Device. <br/>If not, default is `null`.",
 * )
 * --------------------------------------------------
 * Parameter: Device System Version (in=header, required=false).
 * @OA\Parameter(
 *      parameter="Parameters.Api.Share.Devices.SystemVersion.InHeader",
 *      name="X-SYSTEM-VERSION",
 *      in="header",
 *      required=false,
 *      @OA\Schema(
 *          type="string",
 *          maxLength=100,
 *          nullable=true,
 *          example="10.1.0",
 *          default="null",
 *      ),
 *      description="System Version of the Device. <br/>If not, default is `null`.",
 * )
 */
final class DeviceParameter { }
