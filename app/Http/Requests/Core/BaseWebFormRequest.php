<?php

namespace App\Http\Requests\Core;

use App\Http\Responses\Traits\WebResult;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class BaseWebFormRequest
 *
 * @package App\Http\Requests\Core
 */
class BaseWebFormRequest extends FormRequest
{
    use WebResult;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            //
        ];
    }

    /**
     * Handle a passed validation attempt.
     *
     * @return void
     */
    protected function passedValidation(): void
    {
        //
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator): void
    {
        parent::failedValidation($validator);
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function failedAuthorization(): void
    {
        parent::failedAuthorization();
    }

    /**
     * Merge Default data to Input request data after passed validation.
     *
     * @param array $default <p>Default input data.</p>
     * @return void
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    protected function mergeDataPassedValidation(array $default = []): void
    {
        $input = $this->validator->getData();

        // set default value to InputSource (all())
        $this->merge($default);
        // set default value to validated
        $this->validator->setData(array_merge($input, $default));
    }
}
