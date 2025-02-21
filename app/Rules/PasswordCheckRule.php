<?php

namespace App\Rules;

use App\Models\Core\BaseAuthModel;
use App\Rules\Core\BaseRule;
use Illuminate\Support\Facades\Hash;

/**
 * Class PasswordCheckRule
 *
 * @package App\Rules
 */
class PasswordCheckRule extends BaseRule
{
    /**
     * @var BaseAuthModel Authenticatable instance.
     */
    protected BaseAuthModel $authenticatable;

    /**
     * PasswordCheckRule Constructor
     *
     * @param BaseAuthModel $authenticatable
     */
    public function __construct(BaseAuthModel $authenticatable)
    {
        $this->authenticatable = $authenticatable;

        $this->message = __('validation.custom.password.incorrect');
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return Hash::check($value, $this->authenticatable->password);
    }
}
