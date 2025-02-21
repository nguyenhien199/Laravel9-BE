<?php

namespace App\Rules\Core;

use Illuminate\Contracts\Validation\Rule;

/**
 * Class BaseRule
 *
 * @package App\Rules\Core
 */
abstract class BaseRule implements Rule
{
    /**
     * @var string
     */
    protected string $message = 'Error';

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message(): array|string
    {
        return $this->message;
    }
}
