<?php

/**
 * Date regex rule: yyyy/mm/dd | yyyy-mm-dd | yyyy-m-d | yyyy/m/d
 */
const DATE_REGEX_RULE = "/^[0-9]{4}((\-([1-9]|0[1-9]|1[0-2])\-)|(\/([1-9]|0[1-9]|1[0-2])\/))([1-9]|0[1-9]|[12][0-9]|3[01])$/";

/**
 * Date or Carbon format: yyyy-mm-dd
 */
const DATE_FORMAT = "Y-m-d";

/**
 * Date time or Carbon format: yyyy-mm-dd hh:ii:ss
 */
const DATE_TIME_FORMAT = "Y-m-d H:i:s";

/**
 * Date or Carbon format: yyyy/mm/dd
 */
const DATE_FORMAT_EXPORT = "Y/m/d";

/**
 * Date time or Carbon format: yyyy/mm/dd hh:ii:ss
 */
const DATE_TIME_FORMAT_EXPORT = "Y/m/d H:i:s";

/**
 * Date format for set file name: yyyymmdd
 */
const DATE_FORMAT_FILE_NAME = "Ymd";

/**
 * Date time format for set file name: yyyymmdd_hhiiss
 */
const DATE_TIME_FORMAT_FILE_NAME = "Ymd_His";
