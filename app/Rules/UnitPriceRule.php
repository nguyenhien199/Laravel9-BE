<?php

namespace App\Rules;

/**
 * Class UnitPriceRule
 *
 * @package App\Rules
 */
class UnitPriceRule extends Core\BaseRule
{
    /**
     * @var int <p>Minimum value of UnitPrice.</p>
     */
    private int $minimum;

    /**
     * @var int <p>Maximum value of UnitPrice.</p>
     */
    private int $maximum;

    /**
     * UnitPriceRule Constructor
     *
     * @param int $minimum <p>Minimum value of UnitPrice (signed integer).</p>
     * @param int $maximum <p>Maximum value of UnitPrice (signed integer).</p>
     */
    public function __construct(int $minimum = MYSQL_INT_MIN, int $maximum = MYSQL_INT_MAX)
    {
        $this->minimum = max(MYSQL_INT_MIN, min(MYSQL_INT_MAX, $minimum));
        $this->maximum = max($this->minimum, min(MYSQL_INT_MAX, $maximum));
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
        if (filter_var($value, FILTER_VALIDATE_INT) === false || !preg_match('/^([\-\+]\d|\d)\d*$/', $value)) {
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
