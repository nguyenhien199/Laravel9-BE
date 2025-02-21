<?php

namespace App\Providers;

use App\Constants\MorphConst;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

/**
 * Class PolymorphicServiceProvider
 *
 * @package App\Providers
 */
class PolymorphicServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot(): void
    {
        Relation::morphMap(MorphConst::getMorphMaps());
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }
}
