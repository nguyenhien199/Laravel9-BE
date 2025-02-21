<?php

namespace App\Rules;

/**
 * Class PerPageRule
 *
 * @package App\Rules
 */
class PerPageRule extends Core\BaseRule
{
    /**
     * @var int <p>Minimum value of PerPage.</p>
     */
    private int $minimum;

    /**
     * @var int <p>Maximum value of PerPage.</p>
     */
    private int $maximum;

    /**
     * PerPageRule Constructor
     *
     * @param int $minimum <p>Minimum value of PerPage (unsigned integer).</p>
     * @param int $maximum <p>Maximum value of PerPage (unsigned integer).</p>
     */
    public function __construct(int $minimum = 1, int $maximum = 500)
    {
        $this->minimum = max(1, $minimum);
        $this->maximum = max($this->minimum, $maximum);
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
