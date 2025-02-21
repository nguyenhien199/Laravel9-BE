<?php

if (!function_exists('fn_gen_new_code')) {
    /**
     * Gen new ObjectCode by ObjectId.
     *
     * @param string     $prefix <p>Object's Code prefix.</p>
     * @param int|string $objId  <p>ID of Object to create new Code.</p>
     * @param int        $length <p>Extended length of ObjectId when generating Code.</p>
     * @param string     $suffix <p>Object's Code suffix.</p>
     * @return string The new code.
     */
    function fn_gen_new_code(string $prefix = '', int|string $objId = '', int $length = 6, string $suffix = ''): string
    {
        if (strlen($prefix)) {
            $length = $length - strlen($prefix);
        }
        if (strlen($suffix)) {
            $length = $length - strlen($suffix);
        }
        if ($length < 0) {
            return '';
        }

        if (gettype($objId) === 'integer' && $objId <= 0) {
            $objId = '';
        }
        $objId = mb_remove_special_characters($objId);
        if (strlen($objId) <= 0) {
            $newCode = fn_random_string(($length > 1 ? $length - 1 : $length), false, 'd').'R'; // R: Random
        }
        elseif (strlen($objId) > $length) {
            $newCode = substr($objId, (strlen($objId) - $length - 1), $length);
        }
        else {
            $subLength = $length - strlen($objId);
            for ($i = 1; $i <= $subLength; $i++) {
                $objId = '0'.$objId;
            }
            $newCode = $objId;
        }
        return (strlen($prefix) ? $prefix : '').$newCode.(strlen($suffix) ? $suffix : '');
    }
}

if (!function_exists('fn_gen_code_to_mark_deletion')) {
    /**
     * Create a new code for delete logic.
     *
     * @param string $code      <p>Current Code.</p>
     * @param int    $maxLength <p>Code column max length.</p>
     * @return string New code to mark deletion.
     */
    function fn_gen_code_to_mark_deletion(string $code = '', int $maxLength = 9): string
    {
        $timestamp = (new DateTime())->getTimestamp();
        if ($maxLength < 1) {
            return '';
        }
        elseif ($maxLength < strlen($timestamp)) {
            return substr($timestamp, 0, $maxLength);
        }
        else {
            return (!empty($code)) ? (substr($code, 0, ($maxLength - strlen($timestamp))).'.'.$timestamp) : $timestamp;
        }
    }
}
