<?php

namespace App\Http\Requests\Api\Front\Auth;

use App\Enums\RememberLoginFlag;
use App\Http\Requests\Core\BaseApiFormRequest;
use Illuminate\Validation\Rule;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Requests.Api.Front.Auth.Login",
 *     title="Requests.Api.Front.Auth.Login",
 *     description="Request Login body data",
 *     type="object",
 *     required={"username", "password"},
 * )
 */
final class LoginApiFrontRequest extends BaseApiFormRequest
{
    /**
     * @OA\Property(property="username", type="string", format="string", minLength=5, nullable=false, example="",
     *      description="Username to login. <br/>for test env: `user@example.com`.",
     * ),
     * @OA\Property(property="password", type="string", minLength=5, nullable=false, example="",
     *      description="Password to login. <br/>for test env: `password`.",
     * ),
     * @OA\Property(property="remember", type="integer", minimum=0, maximum=1, nullable=true, example=0, default="0",
     *      description="Remember login flag. <br/>In list [`1` remember, `0` no]. <br/>If not, default is `0`."
     * ),
     * @return array
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'min:5'],
            'password' => ['required', 'string', 'min:5'],
            'remember' => ['nullable', 'integer', Rule::in(RememberLoginFlag::getValues())],
        ];
    }
}
