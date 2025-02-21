<?php
/**
 * Phone helpers.
 *
 * @author ThuyVu <thuyvv.hn@gmail.com>
 */

if (!function_exists('fn_remove_special_characters_phone')) {
    /**
     * Remove special characters in phone numbers.
     * (The + sign appears at the beginning, will be preserved)
     *
     * @param string $phone <p>String of phone number.</p>
     * @return string Phone number after remove special characters.
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function fn_remove_special_characters_phone(string $phone): string
    {
        $phone = (function_exists('mb_trim') ? mb_trim($phone) : trim($phone));

        // Remove white space, dots, hyphens and brackets.
        $phone = str_replace([' ', '.', '-', '(', ')'], '', $phone);

        $firstPlus = false;
        if (preg_match('/^[+][0-9]/', $phone)) {
            $firstPlus = true;
        }

        return ($firstPlus ? '+' : '').str_replace(['+'], '', $phone);
    }
}

if (!function_exists('fn_normalize_phone')) {
    /**
     * Phone number normalization.
     * (Remove special characters, keep the + sign at the beginning if any
     * Digits at the beginning are different from + or different from zero, the leading 0 will be added)
     *
     * @param string $phone <p>Phone number input.</p>
     * @return string Phone number after normalization.
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function fn_normalize_phone(string $phone): string
    {
        $phone = fn_remove_special_characters_phone($phone);

        if (!preg_match('/^[+|0]/', $phone)) {
            $phone = '0'.$phone;
        }

        return $phone;
    }
}

if (!function_exists('fn_is_phone')) {
    /**
     * Check the number format of a phone number string.
     * (Phone number string can include special characters)
     *
     * @param string $phone     <p>String of phone number.</p>
     * @param int    $minDigits [optional] <p>Minimum number of digits (default: 9).</p>
     * @param int    $maxDigits [optional] <p>Maximum number of digits (default: 15).</p>
     * @return bool TRUE: correct Phone format, FALSE: incorrect Phone format.
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function fn_is_phone(string $phone, int $minDigits = 9, int $maxDigits = 15): bool
    {
        $phone = fn_remove_special_characters_phone($phone);

        if (preg_match('/^[+][0-9]/', $phone)) {
            $countPlus = 1;
            $phone = str_replace(['+'], '', $phone, $countPlus);
        }

        // Phone number is at least 9($minDigits) digits long, if 9($minDigits) digits long, the first number must be different from 0.
        if (strlen($phone) <= ($minDigits - 1) && preg_match('/^[0]/', $phone)) {
            return false;
        }

        // Are we left with digits only?
        return (bool)preg_match('/^[0-9]{'.$minDigits.','.$maxDigits.'}\z/', $phone);
    }
}
