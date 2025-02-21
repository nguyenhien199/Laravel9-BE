<?php

namespace App\Rules;

/**
 * Class PageRule
 *
 * @package App\Rules
 */
class PageRule extends Core\BaseRule
{
    /**
     * @var int <p>Minimum value of Page.</p>
     */
    private int $minimum;

    /**
     * @var int <p>Maximum value of Page.</p>
     */
    private int $maximum;

    /**
     * PageRule Constructor
     */
    public function __construct()
    {
        $this->minimum = 1;
        $this->maximum = MYSQL_INT_UNSIGNED_MAX;
        $this->message = trans('validation.integer');
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
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
