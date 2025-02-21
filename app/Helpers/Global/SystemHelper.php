<?php
/**
 * System helpers.
 *
 * @author ThuyVu <thuyvv.hn@gmail.com>
 */

if (!function_exists('fn_include_files')) {
    /**
     * Loops through a folder and requires all PHP files.
     * Searches subdirectories as well.
     *
     * @param string $directory <p>Directory path.</p>
     * @return void
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function fn_include_files(string $directory): void
    {
        try {
            $rdi = new RecursiveDirectoryIterator($directory);
            $rii = new RecursiveIteratorIterator($rdi);

            while ($rii->valid()) {
                if (
                    !$rii->isDot() && $rii->isFile() && $rii->isReadable()
                    && $rii->current()->getExtension() === 'php'
                ) {
                    require_once($rii->key());
                }

                $rii->next();
            }
        }
        catch (Throwable $e) {
            echo $e->getMessage();
        }
    }
}

if (!function_exists('fn_include_route_files')) {
    /**
     * Include Route files
     *
     * @param string $directory <p>Route directory path.</p>
     * @return void
     * @author ThuyVu <thuyvv.hn@gmail.com>
     */
    function fn_include_route_files(string $directory): void
    {
        fn_include_files($directory);
    }
}
