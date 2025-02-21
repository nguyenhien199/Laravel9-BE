<?php

namespace App\Rules;

/**
 * Class CodeRule
 *
 * @package App\Rules
 */
class CodeRule extends Core\BaseRule
{
    /**
     * @var int <p>Maximum length of Code.</p>
     */
    private int $maxLength;

    /**
     * CodeRule Constructor
     *
     * @param int $maxLength <p>Maximum length of Code (unsigned integer).</p>
     */
    public function __construct(int $maxLength = 20)
    {
        $this->maxLength = max(1, $maxLength);
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
        if (!is_string($value) && !is_numeric($value)) {
            $this->message = trans('validation.string');
            return false;
        }
        if (!preg_match('/^[\pL\pM\pN_-]+$/u', $value)) {
            $this->message = trans('validation.alpha_dash');
            return false;
        }
        if (strlen($value) > $this->maxLength) {
            $this->message = trans('validation.max.string', ['attribute' => $attribute, 'max' => $this->maxLength]);
            return false;
        }

        return true;
    }
}
