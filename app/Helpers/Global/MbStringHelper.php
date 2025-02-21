<?php
/**
 * Extended multi-byte helper.
 *
 * @author ThuyVu <thuyvv.hn@gmail.com>
 */

/**
 * List trim Character for Multibyte string.
 */
defined('MB_TRIM_CHARACTERS') || define('MB_TRIM_CHARACTERS', "  \t\n\r\0\x0B");

if (!function_exists('mb_trim')) {
    /**
     * Strip whitespace (or other characters) from the beginning and end of a string.
     * (with multibyte support)
     * <ul>
     * <li>"　" (U+3000 12288), a Full-width space.
     * <li>" " (ASCII 32 (0x20)), an ordinary space.
     * <li>"\t" (ASCII 9 (0x09)), a tab.
     * <li>"\n" (ASCII 10 (0x0A)), a new line (line feed).
     * <li>"\r" (ASCII 13 (0x0D)), a carriage return.
     * <li>"\0" (ASCII 0 (0x00)), the NUL-byte.
     * <li>"\x0B" (ASCII 11 (0x0B)), a vertical tab.
     * </ul>
     *
     * @param string|null $text       <p>The input string.</p>
     * @param string      $characters [optional] <p>
     *                                Optionally, the stripped characters can also be specified using the char list parameter.
     *                                Simply list all characters that you want to be stripped.
     *                                With ... you can specify a range of characters.
     *                                </p>
     * @return string The trimmed string.
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function mb_trim(null|string $text = null, string $characters = MB_TRIM_CHARACTERS): string
    {
        if (empty($text)) {
            return '';
        }
        mb_internal_encoding('UTF-8');
        mb_regex_encoding('UTF-8');
        $text = mb_ereg_replace("^[{$characters}]+", '', $text);
        $text = mb_ereg_replace("[{$characters}]+$", '', $text);
        return trim($text);
    }
}

if (!function_exists('mb_ltrim')) {
    /**
     * Strip whitespace (or other characters) from the beginning of a string.
     * (with multibyte support)
     *  <ul>
     *  <li>"　" (U+3000 12288), a Full-width space.
     *  <li>" " (ASCII 32 (0x20)), an ordinary space.
     *  <li>"\t" (ASCII 9 (0x09)), a tab.
     *  <li>"\n" (ASCII 10 (0x0A)), a new line (line feed).
     *  <li>"\r" (ASCII 13 (0x0D)), a carriage return.
     *  <li>"\0" (ASCII 0 (0x00)), the NUL-byte.
     *  <li>"\x0B" (ASCII 11 (0x0B)), a vertical tab.
     *  </ul>
     *
     * @param string|null $text       <p>The input string.</p>
     * @param string      $characters [optional] <p>
     *                                Optionally, the stripped characters can also be specified using the char list parameter.
     *                                Simply list all characters that you want to be stripped.
     *                                With ... you can specify a range of characters.
     *                                </p>
     * @return string The trimmed string.
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function mb_ltrim(null|string $text = null, string $characters = MB_TRIM_CHARACTERS): string
    {
        if (empty($text)) {
            return '';
        }
        mb_internal_encoding('UTF-8');
        mb_regex_encoding('UTF-8');
        $text = mb_ereg_replace("^[{$characters}]+", '', $text);
        return ltrim($text);
    }
}

if (!function_exists('mb_rtrim')) {
    /**
     * Strip whitespace (or other characters) from the end of a string.
     * (with multibyte support)
     * <ul>
     * <li>"　" (U+3000 12288), a Full-width space.
     * <li>" " (ASCII 32 (0x20)), an ordinary space.
     * <li>"\t" (ASCII 9 (0x09)), a tab.
     * <li>"\n" (ASCII 10 (0x0A)), a new line (line feed).
     * <li>"\r" (ASCII 13 (0x0D)), a carriage return.
     * <li>"\0" (ASCII 0 (0x00)), the NUL-byte.
     * <li>"\x0B" (ASCII 11 (0x0B)), a vertical tab.
     * </ul>
     *
     * @param string|null $text       <p>The input string.</p>
     * @param string      $characters [optional] <p>
     *                                Optionally, the stripped characters can also be specified using the char-list parameter.
     *                                Simply list all characters that you want to be stripped.
     *                                With ... you can specify a range of characters.
     *                                </p>
     * @return string The trimmed string.
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function mb_rtrim(null|string $text = null, string $characters = MB_TRIM_CHARACTERS): string
    {
        if (empty($text)) {
            return '';
        }
        mb_internal_encoding('UTF-8');
        mb_regex_encoding('UTF-8');
        $text = mb_ereg_replace("[{$characters}]+$", '', $text);
        return rtrim($text);
    }
}

if (!function_exists('mb_remove_special_characters')) {
    /**
     * Strip whitespace (or other characters) and remove special characters.
     * (with multibyte support)
     *
     * @param string|null $text <p>The input string.</p>
     * @return string The modified string.
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function mb_remove_special_characters(null|string $text = null): string
    {
        if (empty($text)) {
            return '';
        }
        mb_internal_encoding('UTF-8');
        mb_regex_encoding('UTF-8');
        $characters = MB_TRIM_CHARACTERS;
        $text = mb_ereg_replace("^[{$characters}]+", '', $text);
        $text = mb_ereg_replace("[{$characters}]+$", '', $text);
        $text = mb_ereg_replace("[!@%~`$\#\^\&\*\(\)\+\={}\[\]\;\:'\<\>\?\|\/\\\"\n\r\t]*", '', $text);
        return trim($text);
    }
}
