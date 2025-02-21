<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * Class HelperServiceProvider
 *
 * @package App\Providers
 */
class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot(): void
    {
        // Helpers/Global
        $helperPath = app_path('Helpers'.DIRECTORY_SEPARATOR.'Global');
        $rdi = new RecursiveDirectoryIterator($helperPath);
        $rii = new RecursiveIteratorIterator($rdi);
        while ($rii->valid()) {
            if (
                !$rii->isDot() && $rii->isFile() && $rii->isReadable()
                && $rii->current()->getExtension() === 'php'
                && str_ends_with($rii->current()->getFilename(), 'Helper.php')
            ) {
                require $rii->key();
            }
            $rii->next();
        }
    }
}
