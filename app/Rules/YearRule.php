<?php

namespace App\Rules;

/**
 * Class YearRule
 *
 * @package App\Rules
 */
class YearRule extends Core\BaseRule
{
    /**
     * @var int <p>Minimum value of Year.</p>
     */
    private int $minimum;

    /**
     * @var int <p>Maximum value of Year.</p>
     */
    private int $maximum;

    /**
     * YearRule Constructor
     *
     * @param int $minimum <p>Minimum value of Year (unsigned integer).</p>
     * @param int $maximum <p>Maximum value of Year (unsigned integer).</p>
     */
    public function __construct(int $minimum = 1970, int $maximum = 9999)
    {
        $this->minimum = max(0, $minimum);
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
