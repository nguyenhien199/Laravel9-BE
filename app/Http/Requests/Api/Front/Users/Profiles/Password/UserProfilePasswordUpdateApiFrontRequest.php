<?php

namespace App\Http\Requests\Api\Front\Users\Profiles\Password;

use App\Http\Requests\Core\BaseApiFormRequest;
use App\Rules\PasswordCheckRule;
use App\Rules\PasswordRule;
use App\Rules\PasswordUnusedRule;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Requests.Api.Front.Users.Profiles.Password.Update",
 *     title="Requests.Api.Front.Users.Profiles.Password.Update",
 *     description="User profile change password request body data",
 *     type="object",
 *     required={"current_password", "password", "password_confirmation"},
 * )
 */
class UserProfilePasswordUpdateApiFrontRequest extends BaseApiFormRequest
{
    /**
     * @OA\Property(property="current_password", type="string", minLength=8, maxLength=20, nullable=false, example="Pass@w0rd",
     *      description="Current password. </br>You must provide your current password in order to change it."
     * ),
     * @OA\Property(property="password", type="string", minLength=8, maxLength=20, nullable=false, example="NewPass@w0rd",
     *      pattern="^(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*\W)\S{8,20}$",
     *      description="New password.<br> Rule: The password must contain at least one uppercase, one lowercase letter, one number and one special character."
     * ),
     * @OA\Property(property="password_confirmation", type="string", nullable=false, example="NewPass@w0rd",
     *      description="Verify new password. <br/>Password confirm must be the same as Password."
     * ),
     * @return array
     */
    public function rules(): array
    {
        return [
            'current_password'      => ['required', 'string', new PasswordCheckRule($this->user())],
            'password'              => ['required', new PasswordRule(), new PasswordUnusedRule($this->user()), 'confirmed'],
            'password_confirmation' => ['required', 'string'],
        ];
    }
}
