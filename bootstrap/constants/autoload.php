<?php

/**
 * Autoload all file .php in files folder
 */
$files = glob(dirname(__FILE__).DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.'*.php');
if ($files === false) {
    throw new RuntimeException("Cannot globally connect function files.");
}
foreach ($files as $file) {
    require_once($file);
}
