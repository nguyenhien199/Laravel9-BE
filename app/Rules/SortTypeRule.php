<?php

namespace App\Rules;

use App\Constants\RepositoryConst;

/**
 * Class SortTypeRule
 *
 * @package App\Rules
 */
class SortTypeRule extends Core\BaseRule
{
    /**
     * SortTypeRule Constructor
     */
    public function __construct()
    {
        $this->message = trans('validation.string');
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute <p>Attribute key.</p>
     * @param mixed  $value     <p>Attribute value.</p>
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        if (!is_string($value)) {
            $this->message = trans('validation.string');
            return false;
        }
        if (!in_array(strtoupper($value), RepositoryConst::getKeySortTypes())) {
            $this->message = trans('validation.in_array', ['attribute' => $attribute, 'other' => implode(',', RepositoryConst::getKeySortTypes())]);
            return false;
        }
        return true;
    }
}
