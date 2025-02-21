<?php

namespace App\Rules;

/**
 * Class BigIdRule
 *
 * @package App\Rules
 */
class BigIdRule extends Core\BaseRule
{
    /**
     * @var int <p>Maximum length of BigId.</p>
     */
    private int $maxLength;

    /**
     * @var int <p>Minimum value of BigId.</p>
     */
    private int $minimum;

    /**
     * @var int <p>Maximum value of BigId.</p>
     */
    private int $maximum;

    /**
     * BigIdRule Constructor
     */
    public function __construct()
    {
        $this->minimum = 1;
        $this->maximum = MYSQL_BIGINT_MAX;
        $this->maxLength = 20;
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
        if (strlen($value) > $this->maxLength) {
            $this->message = trans('validation.max.string', ['attribute' => $attribute, 'max' => $this->maxLength]);
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
