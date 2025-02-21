<?php

namespace App\Rules;

/**
 * Class PhoneRule
 *
 * @package App\Rules
 */
class PhoneRule extends Core\BaseRule
{
    /**
     * @var int <p>Minimum length of Phone.</p>
     */
    private int $minLength;

    /**
     * @var int <p>Maximum length of Phone.</p>
     */
    private int $maxLength;

    /**
     * PhoneRule Constructor
     *
     * @param int $minLength <p>Minimum length of Phone (unsigned integer).</p>
     * @param int $maxLength <p>Maximum length of Phone (unsigned integer).</p>
     */
    public function __construct(int $minLength = 9, int $maxLength = 15)
    {
        $this->minLength = max(0, $minLength);
        $this->maxLength = max($this->minLength, $maxLength);
        $this->message = trans('validation.integer');
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
        if (strlen($value) < $this->minLength) {
            $this->message = trans('validation.min.numeric', ['attribute' => $attribute, 'min' => $this->minLength]);
            return false;
        }
        if (strlen($value) > $this->maxLength) {
            $this->message = trans('validation.max.numeric', ['attribute' => $attribute, 'max' => $this->maxLength]);
            return false;
        }
        $pattern = '/^(\+\d|\d)\d{'.($this->minLength - 1).','.($this->maxLength - 1).'}$/';
        if (!preg_match($pattern, $value)) {
            $this->message = trans('validation.custom.phone.invalid');
            return false;
        }
        return true;
    }
}
