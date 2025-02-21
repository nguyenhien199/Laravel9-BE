<?php

namespace App\Rules;

/**
 * Class QuantityRule
 *
 * @package App\Rules
 */
class QuantityRule extends Core\BaseRule
{
    /**
     * @var int <p>Minimum value of Quantity.</p>
     */
    private int $minimum;

    /**
     * @var int <p>Maximum value of Quantity.</p>
     */
    private int $maximum;

    /**
     * QuantityRule Constructor
     *
     * @param int $minimum <p>Minimum value of Quantity (unsigned integer).</p>
     * @param int $maximum <p>Maximum value of Quantity (unsigned integer).</p>
     */
    public function __construct(int $minimum = MYSQL_INT_UNSIGNED_MIN, int $maximum = MYSQL_INT_UNSIGNED_MAX)
    {
        $this->minimum = max(MYSQL_INT_UNSIGNED_MIN, min(MYSQL_INT_UNSIGNED_MAX, $minimum));
        $this->maximum = max($this->minimum, min(MYSQL_INT_UNSIGNED_MAX, $maximum));
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
