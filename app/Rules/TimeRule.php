<?php

namespace App\Rules;

/**
 * Class TimeRule
 *
 * @package App\Rules
 */
class TimeRule extends Core\BaseRule
{
    /**
     * TimeRule Constructor
     */
    public function __construct()
    {
        $this->message = trans('validation.custom.time');
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
        // Time format (H:i): 00:00 to 23:59
        $pattern = "/^(2[0-3]|[01][0-9]):([0-5][0-9])$/";
        if (!preg_match($pattern, $value)) {
            $this->message = trans('validation.custom.time');
            return false;
        }
        return true;
    }
}
