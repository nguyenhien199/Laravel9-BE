<?php

namespace App\Http\Requests\Api\Admin\Users;

use App\Http\Requests\Core\BaseApiFormRequest;
use App\Rules\PasswordCheckRule;
use App\Rules\PasswordRule;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Requests.Api.Admin.Users.PasswordChange",
 *     title="Requests.Api.Admin.Users.PasswordChange",
 *     description="User change password request body data",
 *     type="object",
 *     required={"my_password", "password", "password_confirmation"},
 * )
 */
class UserPasswordChangeApiAdminRequest extends BaseApiFormRequest
{
    /**
     * @OA\Property(property="my_password", type="string", minLength=8, maxLength=20, nullable=false, example="Pass@w0rd",
     *      description="My password. </br>You must provide your password in order to change it."
     * ),
     * @OA\Property(property="password", type="string", minLength=8, maxLength=20, nullable=false, example="NewPass@w0rd",
     *      pattern="^(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*\W)\S{8,20}$",
     *      description="New password.<br> Rule: The password must contain at least one uppercase, one lowercase letter, one number and one special character."
     * )
     * @OA\Property(property="password_confirmation", type="string", minLength=8, maxLength=20, nullable=false, example="NewPass@w0rd",
     *      description="Verify new password. <br/>Password confirm must be the same as Password."
     * )
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'my_password'           => ['required', 'string', new PasswordCheckRule($this->user())],
            'password'              => ['required', new PasswordRule(), 'confirmed'],
            'password_confirmation' => ['required', 'string'],
        ];
    }
}
