<?php

namespace App\Rules;

/**
 * Class EmailRule
 *
 * @package App\Rules
 */
class EmailRule extends Core\BaseRule
{
    /**
     * @var int <p>Minimum length of Email.</p>
     */
    private int $minLength;

    /**
     * @var int <p>Maximum length of Email.</p>
     */
    private int $maxLength;

    /**
     * EmailRule Constructor
     *
     * @param int $minLength <p>Minimum length of Email (unsigned integer).</p>
     * @param int $maxLength <p>Maximum length of Email (unsigned integer).</p>
     */
    public function __construct(int $minLength = 1, int $maxLength = 100)
    {
        $this->minLength = max(1, $minLength);
        $this->maxLength = max($this->minLength, $maxLength);
        $this->message = trans('validation.email');
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
        if (strlen($value) < $this->minLength) {
            $this->message = trans('validation.min.string', ['attribute' => $attribute, 'min' => $this->minLength]);
            return false;
        }
        if (strlen($value) > $this->maxLength) {
            $this->message = trans('validation.max.string', ['attribute' => $attribute, 'max' => $this->maxLength]);
            return false;
        }
        if (!fn_is_email($value, false, VALIDATE_EMAIL_USE_FILTER_VAR)) {
            $this->message = trans('validation.email');
            return false;
        }
        return true;
    }
}
