<?php
/**
 * String helpers.
 *
 * @author ThuyVu <thuyvv.hn@gmail.com>
 */

if (!function_exists('fn_iconv_chars_utf8')) {
    /**
     * iconv Chars Utf8.
     *
     * @param string $text <p>The input string.</p>
     * @return string The output string has iconv Chars Utf8.
     */
    function fn_iconv_chars_utf8(string $text = ''): string
    {
        if (!($text && (is_string($text) || is_int($text)))) {
            return '';
        }
        return iconv(mb_detect_encoding($text, mb_detect_order(), true), 'UTF-8', $text);
    }
}

if (!function_exists('fn_html_special_chars_utf8')) {
    /**
     * Convert special characters to HTML entities UTF8.
     *
     * @param string $text <p>The input string.</p>
     * @return string The output string Detected Special Chars Utf8.
     */
    function fn_html_special_chars_utf8(string $text = ''): string
    {
        return htmlspecialchars(fn_iconv_chars_utf8($text), ENT_QUOTES);
    }
}

if (!function_exists('fn_remove_accented')) {
    /**
     * Function to convert leading characters to unsigned characters.
     * (remove Vietnamese accents)
     *
     * @param string $text <p>The input string.</p>
     * @return string The output string with removed.
     */
    function fn_remove_accented(string $text = ''): string
    {
        $text = fn_iconv_chars_utf8($text);
        $normalAccentedArr = [
            'a' => ['á', 'à', 'ả', 'ã', 'ạ', 'ă', 'ắ', 'ặ', 'ằ', 'ẳ', 'ẵ', 'â', 'ấ', 'ầ', 'ẩ', 'ẫ', 'ậ'],
            'A' => ['Á', 'À', 'Ả', 'Ã', 'Ạ', 'Ă', 'Ắ', 'Ặ', 'Ằ', 'Ẳ', 'Ẵ', 'Â', 'Ấ', 'Ầ', 'Ẩ', 'Ẫ', 'Ậ'],
            'd' => ['đ'],
            'D' => ['Đ'],
            'e' => ['é', 'è', 'ẻ', 'ẽ', 'ẹ', 'ê', 'ế', 'ề', 'ể', 'ễ', 'ệ'],
            'E' => ['É', 'È', 'Ẻ', 'Ẽ', 'Ẹ', 'Ê', 'Ế', 'Ề', 'Ể', 'Ễ', 'Ệ'],
            'i' => ['í', 'ì', 'ỉ', 'ĩ', 'ị'],
            'I' => ['Í', 'Ì', 'Ỉ', 'Ĩ', 'Ị'],
            'o' => ['ó', 'ò', 'ỏ', 'õ', 'ọ', 'ô', 'ố', 'ồ', 'ổ', 'ỗ', 'ộ', 'ơ', 'ớ', 'ờ', 'ở', 'ỡ', 'ợ'],
            'O' => ['Ó', 'Ò', 'Ỏ', 'Õ', 'Ọ', 'Ô', 'Ố', 'Ồ', 'Ổ', 'Ỗ', 'Ộ', 'Ơ', 'Ớ', 'Ờ', 'Ở', 'Ỡ', 'Ợ'],
            'u' => ['ú', 'ù', 'ủ', 'ũ', 'ụ', 'ư', 'ứ', 'ừ', 'ử', 'ữ', 'ự'],
            'U' => ['Ú', 'Ù', 'Ủ', 'Ũ', 'Ụ', 'Ư', 'Ứ', 'Ừ', 'Ử', 'Ữ', 'Ự'],
            'y' => ['ý', 'ỳ', 'ỷ', 'ỹ', 'ỵ'],
            'Y' => ['Ý', 'Ỳ', 'Ỷ', 'Ỹ', 'Ỵ']
        ];
        foreach ($normalAccentedArr as $nonAccented => $subAccentedArr) {
            $text = str_replace($subAccentedArr, $nonAccented, $text);
        }
        return $text;
    }
}

if (!function_exists('fn_format_string_to_uri')) {
    /**
     * The function just converted the accented character to the unsigned character
     * (also removes spaces and replaces them with an input character)
     *
     * @param string $text        <p>The input string.</p>
     * @param string $charReplace <p>The character that will replace the space.</p>
     * @param bool   $isSetLower  <p>Convert back to lowercase characters?</p>
     * @return string The output string satisfies the requirement
     */
    function fn_format_string_to_uri(string $text = '', string $charReplace = '-', bool $isSetLower = false): string
    {
        // Convert special characters to HTML entities UTF8.
        $text = fn_html_special_chars_utf8($text);
        // Remove accented characters.
        $text = fn_remove_accented($text);
        // Set Lower?
        $isSetLower === true && $text = strtolower($text);
        // Remove special characters.
        $text = preg_replace("/!|@|%|\^|\*|\(|\)|\-|\+|\=|\<|\>|$|\?|\/|,|\.|\:|\;|\\' | |\"|\&|\#|\[|\]|~|_/", $charReplace, $text);
        $text = str_replace('$', $charReplace, $text);
        // Remove repeated $charReplace characters.
        $tempArr = array_filter(
            explode($charReplace, $text),
            function ($item) {
                return $item != '';
            }
        );

        return implode($charReplace, $tempArr);
    }
}

if (!function_exists('fn_random_string')) {
    /**
     * Generate Random String.
     *
     * @param int    $length  <p>Length of desired string</p>
     * @param string $options <p>l:lowercase, u:uppercase, d:digit, s:special|symbol</p>
     * @param bool   $dashes  <p>Makes it much easier for users to manually type or speak their passwords.</p>
     * @return string String has been randomly generated.
     */
    function fn_random_string(int $length = 9, string $options = 'luds', bool $dashes = false): string
    {
        $options = strtolower($options);
        $sets = [];
        if (str_contains($options, 'l')) {
            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        }
        if (str_contains($options, 'u')) {
            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        }
        if (str_contains($options, 'd')) {
            $sets[] = '0123456789';
        }
        if (str_contains($options, 's')) {
            $sets[] = '!@#$%&*?';

            //$special = "~`!@#$%^&*()-_+={}[]|\\/:;\"'<>,.?";
            //
            //$a = ['~', '!', '#', '$', '%', '^', '&', '*', '(', ')', '-',
            //    '_', '.', ',', '<', '>', '?', '/', '\\', '{', '}', '[',
            //    ']', '|', ':', ';',];
        }

        $setsStr = ''; // sets string
        $outStr = '';  // output string

        // By default, each $options type will have at least 1 character.
        foreach ($sets as $set) {
            $outStr .= $set[array_rand(str_split($set))];
            $setsStr .= $set;
        }

        // Convert a string to an array
        $setsArr = str_split($setsStr);

        for ($i = 0; $i < $length - count($sets); $i++) {
            $outStr .= $setsArr[array_rand($setsArr)];
        }

        // Randomly shuffles a string
        $outStr = str_shuffle($outStr);

        if (!$dashes) {
            return $outStr;
        }

        $dashLength = floor(sqrt($length));
        $dashStr = '';
        while (strlen($outStr) > $dashLength) {
            $dashStr .= substr($outStr, 0, $dashLength).'-';
            $outStr = substr($outStr, $dashLength);
        }
        $dashStr .= $outStr;

        return $dashStr;
    }
}
