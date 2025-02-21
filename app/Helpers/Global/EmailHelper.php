<?php
/**
 * Email helpers.
 *
 * @author ThuyVu <thuyvv.hn@gmail.com>
 */

/**
 * ID of "validate_email" filter.
 *
 * @link https://php.net/manual/en/filter.constants.php
 */
defined('VALIDATE_EMAIL_USE_FILTER_VAR') || define('VALIDATE_EMAIL_USE_FILTER_VAR', 1);

/**
 * Test Email using standard RFC5322 regular expressions.
 * RFC5322 origin:
 * (?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])
 *
 * @link https://datatracker.ietf.org/doc/html/rfc5322
 * @link https://emailregex.com/index.html
 * @link https://uibakery.io/regex-library/email-regex-php
 * @link https://github.com/iamcal/rfc822/blob/master/rfc822.php
 */
defined('VALIDATE_EMAIL_USE_REGEX_RFC5322') || define('VALIDATE_EMAIL_USE_REGEX_RFC5322', 2);

/**
 * Test Email using custom regular expressions.
 * ^([a-z0-9])(([._-]?[a-z0-9]+)*)@([a-z0-9]([-]?[a-z0-9]+)*)((\.?([a-z0-9]([-]?[a-z0-9]+)*))*)(\.[a-z]{2,3})$
 */
defined('VALIDATE_EMAIL_USE_REGEX_CUSTOM') || define('VALIDATE_EMAIL_USE_REGEX_CUSTOM', 3);

if (!function_exists('fn_normalize_email')) {
    /**
     * Email normalization.
     * (removes leading and trailing whitespace characters, returns to lowercase)
     *
     * @param string $email <p>Email input.</p>
     * @return string Email after normalization.
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function fn_normalize_email(string $email): string
    {
        $email = (function_exists('mb_trim') ? mb_trim($email) : trim($email));
        return strtolower($email);
    }
}

if (!function_exists('fn_is_email')) {
    /**
     * Check if the format is a valid Email?
     *
     * @param string $email     <p>Email to check.</p>
     * @param bool   $lowercase [optional] <p>Use string to lowercase before checking? (default: FALSE)</p>
     * @param int    $flag      [optional] <p>Select test method (default: VALIDATE_EMAIL_USE_FILTER_VAR): <br/>
     *                          <b>VALIDATE_EMAIL_USE_FILTER_VAR</b> : Using `filter_var` function. <br/>
     *                          <b>VALIDATE_EMAIL_USE_REGEX_RFC5322</b> : Using standard RFC5322 regular expressions. <br/>
     *                          <b>VALIDATE_EMAIL_USE_FILTER_VAR</b> : Using custom regular expressions.
     *                          </p>
     * @return bool TRUE: correct Email format, FALSE: incorrect Email format.
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function fn_is_email(string $email, bool $lowercase = false, int $flag = VALIDATE_EMAIL_USE_FILTER_VAR): bool
    {
        if (empty($email)) {
            return false;
        }
        if ($lowercase) {
            $email = strtolower($email);
        }
        if ($flag == VALIDATE_EMAIL_USE_REGEX_RFC5322) {
            $pattern = "/(?:[a-z0-9!#$%&'*+\\/=?^_`{|}~-]+(?:\\.[a-z0-9!#$%&'*+\\/=?^_`{|}~-]+)*|\"(?:[\\x01-\\x08\\x0b\\x0c\\x0e-\\x1f\\x21\\x23-\\x5b\\x5d-\\x7f]|\\\\[\\x01-\\x09\\x0b\\x0c\\x0e-\\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\\x01-\\x08\\x0b\\x0c\\x0e-\\x1f\\x21-\\x5a\\x53-\\x7f]|\\\\[\\x01-\\x09\\x0b\\x0c\\x0e-\\x7f])+)\\])/";
        }
        elseif ($flag == VALIDATE_EMAIL_USE_REGEX_CUSTOM) {
            // Gmail only
            if (preg_match('/@(g(oogle)?mail\.com)(\.[a-z]{2,3})?$/', $email)) {
                $pattern = '/^([a-z0-9])(([.]?[a-z0-9]+)*)@(g(oogle)?mail\.com)(\.[a-z]{2,3})?$/';
            }
            // Other
            else {
                $pattern = '/^([a-z0-9])(([._-]?[a-z0-9]+)*)@([a-z0-9]([-]?[a-z0-9]+)*)((\.?([a-z0-9]([-]?[a-z0-9]+)*))*)(\.[a-z]{2,3})$/';
            }
        }
        else {
            return (bool)filter_var($email, FILTER_VALIDATE_EMAIL, FILTER_FLAG_EMAIL_UNICODE);
        }

        return (bool)preg_match($pattern, $email);
    }
}
