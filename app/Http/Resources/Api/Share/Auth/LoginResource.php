<?php

namespace App\Http\Resources\Api\Share\Auth;

use App\Constants\AuthConst;
use App\Http\Resources\Core\BaseResource;
use Spatie\LaravelData\Attributes\MapInputName;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      schema="Resources.Api.Share.Auth.Login",
 *      title="Resources.Api.Share.Auth.Login",
 *      description="logged in successfully resource"
 * )
 */
class LoginResource extends BaseResource
{
    /**
     * @OA\Property(property="access_token", type="string", nullable=false, example="eyJ0eXAiOi...JSUzUxMiJ9.eyJpc3MiOi...AuMC4xOjgw.Yq9wFbsHnI...ObbM9e7kPR", description=""),
     * @var string
     */
    #[MapInputName('access_token')]
    public string $access_token;

    /**
     * @OA\Property(property="token_type", type="string", nullable=false, example="Bearer", description="")
     * @var string
     */
    #[MapInputName('token_type')]
    public string $token_type = AuthConst::TOKEN_TYPE;

    /**
     * @OA\Property(property="expires_in", type="integer", nullable=true, example="3600", default="null", description="Expires in (unit: seconds)")
     * @var int|null
     */
    #[MapInputName('expires_in')]
    public ?int $expires_in = null;
}