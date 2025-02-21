<?php

namespace App\Http\Requests\Core;

use App\Constants\ResponseConst;
use App\Http\Responses\Traits\ApiResult;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class BaseApiFormRequest
 *
 * @package App\Http\Requests\Core
 */
class BaseApiFormRequest extends FormRequest
{
    use ApiResult;

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
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(
            $this->unprocessableEntityApiResult(
                ResponseConst::CODE_FAILED_VALIDATION,
                __('messages.error.failed_validation'),
                \Illuminate\Validation\ValidationException::class,
                (new \Illuminate\Validation\ValidationException($validator))->errors()
            )
        );
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedAuthorization(): void
    {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(
            $this->unauthorizedApiResult(
                ResponseConst::CODE_UNAUTHORIZED,
                __('messages.error.unauthorized'),
                \Illuminate\Auth\Access\AuthorizationException::class
            )
        );
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
