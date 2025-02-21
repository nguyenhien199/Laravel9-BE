<?php

namespace App\Rules;

/**
 * Class PasswordRule
 *
 * @package App\Rules
 */
class PasswordRule extends Core\BaseRule
{
    /**
     * @var int <p>Minimum length of Password.</p>
     */
    private int $minLength;

    /**
     * @var int <p>Maximum length of Password.</p>
     */
    private int $maxLength;

    /**
     * PasswordRule Constructor
     *
     * @param int $minLength <p>Minimum length of Password (unsigned integer).</p>
     * @param int $maxLength <p>Maximum length of Password (unsigned integer).</p>
     */
    public function __construct(int $minLength = 8, int $maxLength = 20)
    {
        $this->minLength = max(1, $minLength);
        $this->maxLength = max($this->minLength, $maxLength);
        $this->message = trans('validation.custom.password.mixture');
    }

    /**
     * Determine if the validation rule passes.
     * <p>^(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*\W)\S{8,20}$</p>
     * <table>
     *     <tr>
     *         <td>^</td>
     *         <td>:Anchored to beginning of string.</td>
     *     </tr>
     *     <tr>
     *         <td>(?=\S*[a-z])</td>
     *         <td>:Containing at least one lowercase letter.</td>
     *     </tr>
     *     <tr>
     *         <td>(?=\S*[A-Z])</td>
     *         <td>:Containing at least one uppercase letter.</td>
     *     </tr>
     *     <tr>
     *         <td>(?=\S*[\d])</td>
     *         <td>:Containing at least one number.</td>
     *     </tr>
     *     <tr>
     *         <td>(?=\S*\W)</td>
     *         <td>:Containing at least one special character.</td>
     *     </tr>
     *     <tr>
     *         <td>\S{8,20}</td>
     *         <td>:Of at least length 8 and of at greatest length 20.</td>
     *     </tr>
     *     <tr>
     *         <td>$</td>
     *         <td>:Anchored to the end of the string.</td>
     *     </tr>
     * </table>
     *
     * @param string $attribute <p>Attribute key.</p>
     * @param mixed  $value     <p>Attribute value.</p>
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        if (!is_string($value) && !is_int($value)) {
            $this->message = trans('validation.string');
            return false;
        }
        if (strlen($value) < $this->minLength) {
            $this->message = trans('validation.min.string', ['attribute' => $attribute, 'min' => $this->minLength]);
            return false;
        }
        if (strlen($value) > $this->maxLength) {
            $this->message = trans('validation.max.string', ['attribute' => $attribute, 'max' => $this->maxLength]);
            return false;
        }
        // Containing at least one lowercase letter.
        if (!preg_match('@[a-z]@', $value)) {
            $this->message = trans('validation.password.mixed', ['attribute' => $attribute]);
            return false;
        }
        // Containing at least one uppercase letter.
        if (!preg_match('@[A-Z]@', $value)) {
            $this->message = trans('validation.password.mixed', ['attribute' => $attribute]);
            return false;
        }
        // Containing at least one number.
        if (!preg_match('@\d@', $value)) {
            $this->message = trans('validation.password.numbers', ['attribute' => $attribute]);
            return false;
        }
        // Containing at least one special character.
        if (!preg_match('/\W/', $value)) {
            $this->message = trans('validation.password.symbols', ['attribute' => $attribute]);
            return false;
        }
        // Perform a regular expression match.
        $pattern = '/^(?=\S*[a-z])(?=\S*[A-Z])(?=\S*\d)(?=\S*\W)\S{'.$this->minLength.','.$this->maxLength.'}$/';
        if (!preg_match($pattern, $value)) {
            $this->message = trans('validation.custom.password.mixture', ['attribute' => $attribute]);
            return false;
        }
        return true;
    }
}
