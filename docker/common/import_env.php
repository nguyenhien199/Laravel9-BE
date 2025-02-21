<?php

## PHP Script Import ENV from Global to `.env` file ############################
# (Supports all PHP versions)
# Usage:
#   1. Copy this file to the project root directory (where the `.env` file is located).
#   2. Can be run with the command:
#       docker run -it --entrypoint=/bin/sh IMAGE_NAME -c "php /PATH_TO_SOURCE/import_env.php"
#           + IMAGE_NAME: Docker Image name to execute.
#           + PATH_TO_SOURCE: Absolute path to the project root directory.
################################################################################

echo "> @php import_env.php\n";
$env_file = dirname(__FILE__).DIRECTORY_SEPARATOR.'.env';
$env_original_contents = '';
if (file_exists($env_file)) {
    $env_original_contents = file_get_contents($env_file);
}
$env_original_contents = explode(PHP_EOL, $env_original_contents);

$env_original_filtered = array_filter($env_original_contents, function ($item) {
    return !empty($item) && !in_array(substr($item, 0, 1), ['', ' ', null, '#']);
});

$env_originals = [];
foreach ($env_original_filtered as $item) {
    $exp = explode('=', $item, 2);
    if (count($exp) && !empty($exp[0]) && preg_match('/^([a-zA-Z0-9\-\_\.])+$/', trim($exp[0]))) {
        $env_key = $exp[0];
        $env_value = substr($item, strlen($env_key) + 1, strlen($item) - strlen($env_key) - 1); // 1 === strlen(=)
        $env_originals[trim($env_key)] = $env_value;
    }
}

$env_news = [];
foreach ($env_originals as $env_key => $env_value) {
    # Get the value of the global environment variable.
    $env_global_value = getenv($env_key);
    if ($env_global_value !== false) {
        # Assign new environment variable.
        $env_value = $env_global_value;
    }
    $env_news[$env_key] = $env_value;
}

$env_new_contents = '';
foreach ($env_news as $env_key => $env_value) {
    $env_new_contents .= $env_key.'='.$env_value.PHP_EOL;
}

# Rewrite `.env` file contents.
file_put_contents($env_file, $env_new_contents);

echo "ENV imported successfully.\n\n";
