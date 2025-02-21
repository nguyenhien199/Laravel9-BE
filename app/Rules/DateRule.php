<?php

namespace App\Rules;

/**
 * Class DateRule
 *
 * @package App\Rules
 */
class DateRule extends Core\BaseRule
{
    /**
     * DateRule Constructor
     */
    public function __construct()
    {
        $this->message = trans('validation.date');
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
        // yyyy/mm/dd | yyyy-mm-dd | yyyy-m-d | yyyy/m/d
        if (!preg_match(DATE_REGEX_RULE, $value)) {
            $this->message = trans('validation.date');
            return false;
        }
        return true;
    }
}
