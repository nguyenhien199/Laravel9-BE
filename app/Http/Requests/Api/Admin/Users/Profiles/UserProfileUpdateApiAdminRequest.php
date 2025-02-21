<?php

namespace App\Http\Requests\Api\Admin\Users\Profiles;

use App\Enums\GenderFlag;
use App\Http\Requests\Core\BaseApiFormRequest;
use App\Rules\DateRule;
use App\Rules\ImageFileRule;
use App\Rules\NameRule;
use App\Rules\PhoneRule;
use Illuminate\Validation\Rule;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      schema="Requests.Api.Admin.Users.Profiles.Update",
 *      title="Requests.Api.Admin.Users.Profiles.Update",
 *      description="User profile update request body data",
 *      type="object",
 *      required={},
 * )
 */
class UserProfileUpdateApiAdminRequest extends BaseApiFormRequest
{
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        //
    }

    /**
     * @OA\Property(property="firstname", type="string", minLength=1, maxLength=100, nullable=true, example="First",
     *      description="First name."
     * ),
     * @OA\Property(property="lastname", type="string", minLength=1, maxLength=100, nullable=true, example="Last",
     *      description="Last name."
     * ),
     * @OA\Property(property="gender", type="integer", minimum=0, maximum=2, nullable=true, example=1,
     *      description="Gender in list: (`0`: Other, `1`: Male, `2`: Female)."
     * ),
     * @OA\Property(property="birthday", type="string", format="date", nullable=true, example="1988-07-23",
     *      pattern="^[0-9]{4}((-([1-9]|0[1-9]|1[0-2])-)|(/([1-9]|0[1-9]|1[0-2])/))([1-9]|0[1-9]|[12][0-9]|3[01])$",
     *      description="Birthday. <br/>Format date: `yyyy/mm/dd`|`yyyy-mm-dd`."
     * ),
     * @OA\Property(property="phone", type="string", minLength=10, maxLength=20, nullable=false, example="0987654322",
     *      description="Phone number. <br/>Format number: `098...`|`+8498...`."
     * ),
     * @OA\Property(property="avatar", type="string", format="binary",
     *      description="Avatar image. Max size 2mb, file extension allow: `.png`, `.jpg`, `.jpeg`, `.gif`."
     * ),
     * @OA\Property(property="description", type="string", maxLength=255, nullable=true, example="This is an example description",
     *      description="Description."
     * ),
     * @OA\Property(property="organization", type="string", maxLength=255, nullable=true, example="Example co., Ltd.",
     *      description="Organization/Company name."
     * ),
     * @OA\Property(property="department", type="string", maxLength=255, nullable=true, example="Product Operation Center",
     *      description="Department name."
     * ),
     * @OA\Property(property="position", type="string", maxLength=255, nullable=true, example="Director",
     *      description="Job position."
     * ),
     * @OA\Property(property="address", type="string", maxLength=255, nullable=true, example="Tran Thu Do street, Hoang Mai district",
     *      description="Address."
     * ),
     * @OA\Property(property="city", type="string", maxLength=255, nullable=true, example="Ha Noi",
     *      description="City name."
     * ),
     * @OA\Property(property="country", type="string", maxLength=255, nullable=true, example="Viet Nam",
     *      description="Country name."
     * ),
     * @return array
     */
    public function rules(): array
    {
        return [
            'firstname'   => ['nullable', new NameRule()],
            'lastname'    => ['nullable', new NameRule()],
            'gender'      => ['nullable', 'integer', Rule::in(GenderFlag::getValues())],
            'birthday'    => ['nullable', new DateRule(), 'date_format:Y-m-d', 'before:'.carbon()->format(DATE_FORMAT)],
            'phone'       => ['nullable', new PhoneRule(), 'unique:users,phone,'.$this->user()->id],
            'avatar'      => ['nullable', new ImageFileRule()],
            'description' => ['nullable', 'string', 'max:255'],

            'organization' => ['nullable', 'string', 'max:255'],
            'department'   => ['nullable', 'string', 'max:255'],
            'position'     => ['nullable', 'string', 'max:255'],
            'address'      => ['nullable', 'string', 'max:255'],
            'city'         => ['nullable', 'string', 'max:255'],
            'country'      => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return parent::messages();
    }

    /**
     * Handle a passed validation attempt.
     *
     * @return void
     */
    protected function passedValidation(): void
    {
        $defaultData = [];
        $inputData = $this->validator->getData();

        if (!empty($inputData['phone'])) {
            $defaultData['phone'] = ltrim($inputData['phone'], '+');
            if (strlen($defaultData['phone']) < 10) {
                $defaultData['phone'] = '0'.$defaultData['phone'];
            }
        }

        // Merge Default data to Input request data after passed validation.
        $this->mergeDataPassedValidation($defaultData);
    }
}
