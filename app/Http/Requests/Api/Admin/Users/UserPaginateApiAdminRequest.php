<?php

namespace App\Http\Requests\Api\Admin\Users;

use App\Constants\ModelConst;
use App\Constants\PageConst;
use App\Constants\RepositoryConst;
use App\Enums\GenderFlag;
use App\Enums\StatusFlag;
use App\Http\Requests\Core\BaseApiFormRequest;
use App\Models\User;
use App\Rules\BigIdRule;
use App\Rules\PageRule;
use App\Rules\PerPageRule;
use App\Rules\SortTypeRule;
use Illuminate\Validation\Rule;

/**
 * Class UserPaginateApiAdminRequest
 *
 * @package App\Http\Requests\Api\Admin\Users
 */
class UserPaginateApiAdminRequest extends BaseApiFormRequest
{
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $inputs = $this->all();
        if (isset($inputs['sort'])) {
            // Set 'sort' to lower
            $this->merge(['sort' => strtolower($this->get('sort'))]);
        }
        if (isset($inputs['sort_type'])) {
            // Set 'sort_type' to upper
            $this->merge(['sort_type' => strtoupper($this->get('sort_type'))]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'user_id' => ['nullable', new BigIdRule()],
            'email'   => ['nullable', 'string'],
            'gender'  => ['nullable', Rule::in(GenderFlag::getValues())],
            'status'  => ['nullable', Rule::in(StatusFlag::getValues())],

            'page'      => ['nullable', new PageRule()],
            'per_page'  => ['nullable', new PerPageRule()],
            'sort'      => ['nullable', Rule::in(array_keys(User::SORT_FIELDS))],
            'sort_type' => ['nullable', new SortTypeRule()],
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

        if (empty($inputData['page'])) {
            $defaultData['page'] = PageConst::PAGE_DEFAULT;
        }
        if (empty($inputData['per_page'])) {
            $defaultData['per_page'] = PageConst::PER_PAGE_DEFAULT;
        }
        if (empty($inputData['sort'])) {
            $defaultData['sort'] = User::SORT_DEFAULT;
        }
        $sort = $defaultData['sort'] ?? $inputData['sort'];
        if (empty($inputData['sort_type'])) {
            $defaultData['sort_type'] = ($sort === ModelConst::ID_PRIMARY)
                ? RepositoryConst::SORT_TYPE_DESC
                : RepositoryConst::SORT_TYPE_ASC;
        }

        // Merge Default data to Input request data after passed validation.
        $this->mergeDataPassedValidation($defaultData);
    }
}