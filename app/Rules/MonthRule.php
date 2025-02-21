<?php

namespace App\Rules;

/**
 * Class MonthRule
 *
 * @package App\Rules
 */
class MonthRule extends Core\BaseRule
{
    /**
     * @var int <p>Minimum value of Month.</p>
     */
    private int $minimum;

    /**
     * @var int <p>Maximum value of Month.</p>
     */
    private int $maximum;

    /**
     * MonthRule Constructor
     */
    public function __construct()
    {
        $this->minimum = 1;
        $this->maximum = 12;
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
        // Process substr when month is: 0x.
        if (strlen($value) == 2 && preg_match('/^(0[1-9])$/', $value) == 1) {
            $value = substr($value, 1, 1);
        }
        if (filter_var($value, FILTER_VALIDATE_INT) === false || !preg_match('/^\d*$/', $value)) {
            $this->message = trans('validation.integer');
            return false;
        }
        if ($value < $this->minimum) {
            $this->message = trans('validation.min.numeric', ['attribute' => $attribute, 'min' => $this->minimum]);
            return false;
        }
        if ($value > $this->maximum) {
            $this->message = trans('validation.max.numeric', ['attribute' => $attribute, 'max' => $this->maximum]);
            return false;
        }
        return true;
    }
}
