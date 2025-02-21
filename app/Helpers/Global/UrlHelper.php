<?php
/**
 * URL helpers
 *
 * @author ThuyVu <thuyvv.hn@gmail.com>
 */

if (!function_exists('fn_normalize_url')) {
    /**
     * Function to standardize Domain URL format.
     * (at the end of Domain always remove the / )
     * (Input URL should always be a full canonical URL)
     * (https://khangvu.vn/abc/... | http://127.0.0.1/abc/...)
     *
     * @param string $url <p>URL to check.</p>
     * @return string URL to return (all last / characters removed)
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function fn_normalize_url(string $url = ''): string
    {
        $url = (function_exists('mb_trim') ? mb_trim($url) : trim($url));
        if (!fn_is_url($url)) {
            return '';
        }

        $temps = explode('/', $url);
        foreach ($temps as $key => $val) {
            if ($key > 1 && $val == '') {
                unset($temps[$key]);
            }
        }
        return implode('/', $temps);
    }
}

if (!function_exists('fn_is_url')) {
    /**
     * Check if the format is 1 URL.
     * (using filter_var function)
     *
     * @param string $url <p>Url string to check.</p>
     * @return bool TRUE: correct Url format, FALSE: incorrect Url format.
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function fn_is_url(string $url = ''): bool
    {
        return (bool)filter_var($url, FILTER_VALIDATE_URL);
    }
}

if (!function_exists('fn_check_url_exist')) {
    /**
     * Check URL exist.
     * (using get_headers function)
     *
     * @param string $url <p>Url string to check.</p>
     * @return bool TRUE: Url exist, FALSE: Url does not exist.
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function fn_check_url_exist(string $url = ''): bool
    {
        $url = (function_exists('mb_trim') ? mb_trim($url) : trim($url));
        if (!fn_is_url($url)) {
            return false;
        }
        try {
            $headers = get_headers($url, true);
            if (!empty($headers[0])) {
                return (bool)stripos($headers[0], "200 OK");
            }
            return false;
        }
        catch (\Throwable $e) {
            return false;
        }
    }
}

if (!function_exists('fn_cut_full_domain_name')) {
    /**
     * Cut and get the full Domain name.
     * (full: http(s)|ftp|ssl://(www.)khangvu.vn)
     *
     * @param string $url      <p>URL input string.</p>
     * @param bool   $useRegex [optional] <p>Support tool (default: TRUE). <br/>
     *                         <b>TRUE</b> : Using regular expression. <br/>
     *                         <b>FALSE</b> : Using Array.
     *                         </p>
     * @return string Full Domain name. If EMPTY: An error has occurred.
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function fn_cut_full_domain_name(string $url = '', bool $useRegex = true): string
    {
        $url = (function_exists('mb_trim') ? mb_trim($url) : trim($url));
        if (!fn_is_url($url)) {
            return '';
        }
        if ($useRegex) {
            return (string)preg_replace('/^(((http(s)?|ssl|ftp):\/\/)?(\/\/)?(www\d?\.)?([^\/?&]+)?)(.*)/', '$1', $url);
        }
        else {
            $temps = explode('/', $url);
            if (in_array($temps[0], ['http:', 'https:', 'ftp:', 'ssl:'])) {
                return $temps[0].'//'.$temps[2];
            }
            elseif ($temps[0]) {
                return $temps[0];
            }
            else {
                return '';
            }
        }
    }
}

if (!function_exists('fn_cut_short_domain_name')) {
    /**
     * Cut and get the short Domain name.
     * (incomplete, removed http(s) and www, ftp, ssl or //)
     *
     * @param string $url      <p>URL input string.</p>
     * @param bool   $useRegex [optional] <p>Support tool (default: TRUE). <br/>
     *                         <b>TRUE</b> : Using regular expression. <br/>
     *                         <b>FALSE</b> : Using Array.
     *                         </p>
     * @return string Short Domain name. If EMPTY: An error has occurred.
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function fn_cut_short_domain_name(string $url = '', bool $useRegex = true): string
    {
        $url = (function_exists('mb_trim') ? mb_trim($url) : trim($url));
        if (!fn_is_url($url)) {
            return '';
        }
        if ($useRegex) {
            return (string)preg_replace('/^(((http(s)?|ssl|ftp):\/\/)?(\/\/)?(www\d?\.)?([^\/?&]+)?)(.*)/', '$7', $url);
        }
        else {
            $temps = explode('/', $url);
            $outUrl = '';
            if ($temps[0] == '') {
                unset($temps[0]);
                $outUrl = fn_cut_full_domain_name(implode('/', $temps), false);
            }
            elseif (in_array($temps[0], ['http:', 'https:', 'ftp:', 'ssl:'])) {
                $outUrl = $temps[2];
            }
            elseif ($temps[0]) {
                $outUrl = $temps[0];
            }

            $dots = explode('.', $outUrl);
            if (str_starts_with($dots[0], 'www')) {
                unset($dots[0]);
                $outUrl = implode('.', $dots);
            }

            return $outUrl;
        }
    }
}
