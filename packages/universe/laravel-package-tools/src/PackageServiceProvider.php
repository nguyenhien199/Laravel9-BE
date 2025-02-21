<?php

namespace Universe\PackageTools;

use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use ReflectionClass;
use Universe\PackageTools\Exceptions\InvalidPackage;

/**
 * Class PackageServiceProvider
 *
 * @package Universe\PackageTools
 */
abstract class PackageServiceProvider extends ServiceProvider
{
    /**
     * @var Package Package instance.
     */
    protected Package $package;

    /**
     * Configure Package.
     *
     * @param Package $package Package instance.
     * @return void
     */
    abstract public function configurePackage(Package $package): void;

    /**
     * Generate Migration name.
     *
     * @param string $migrationFileName
     * @param Carbon $now
     * @return string
     */
    public static function generateMigrationName(string $migrationFileName, Carbon $now): string
    {
        $migrationsPath = 'migrations/';

        $len = strlen($migrationFileName) + 4;

        if (Str::contains($migrationFileName, '/')) {
            $migrationsPath .= Str::of($migrationFileName)->beforeLast('/')->finish('/');
            $migrationFileName = Str::of($migrationFileName)->afterLast('/');
        }

        foreach (glob(database_path("{$migrationsPath}*.php")) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName.'.php')) {
                return $filename;
            }
        }

        return database_path($migrationsPath.$now->format('Y_m_d_His').'_'.Str::of($migrationFileName)->snake()->finish('.php'));
    }

    /**
     * Create new Package Instance.
     *
     * @return Package
     */
    public function newPackage(): Package
    {
        return new Package();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        // Registering Package.
        $this->registeringPackage();

        $this->package = $this->newPackage();

        $this->package->setBasePath($this->getPackageBaseDir());

        $this->configurePackage($this->package);

        if (empty($this->package->name)) {
            throw InvalidPackage::nameIsRequired();
        }

        foreach ($this->package->configFileNames as $configFileName) {
            $this->mergeConfigFrom($this->package->basePath("/config/{$configFileName}.php"), $configFileName);
        }

        // Package Registered.
        $this->packageRegistered();
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // Booting Package.
        $this->bootingPackage();

        if ($this->package->hasTranslations) {
            $langPath = 'vendor/'.$this->package->shortName();
            $langPath = (function_exists('lang_path'))
                ? lang_path($langPath)
                : resource_path('lang/'.$langPath);
        }

        if ($this->app->runningInConsole()) {
            // Publishing the Configuration files.
            foreach ($this->package->configFileNames as $configFileName) {
                $this->publishes(
                    [$this->package->basePath("/config/{$configFileName}.php") => config_path("{$configFileName}.php")],
                    "{$this->package->shortName()}-config"
                );
            }

            // Publishing the View resource files.
            if ($this->package->hasViews) {
                $this->publishes(
                    [$this->package->basePath('/resources/views') => base_path("resources/views/vendor/{$this->packageView($this->package->viewNamespace)}")],
                    "{$this->packageView($this->package->viewNamespace)}-views"
                );
            }

            // Publishing the Inertia-Component resource files.
            if ($this->package->hasInertiaComponents) {
                $packageDirectoryName = Str::of($this->packageView($this->package->viewNamespace))->studly()->remove('-')->value();

                $this->publishes(
                    [$this->package->basePath('/resources/js/Pages') => base_path("resources/js/Pages/{$packageDirectoryName}")],
                    "{$this->packageView($this->package->viewNamespace)}-inertia-components"
                );
            }

            // Publishing the Migration files.
            $now = Carbon::now();
            foreach ($this->package->migrationFileNames as $migrationFileName) {
                $filePath = $this->package->basePath("/database/migrations/{$migrationFileName}.php");
                if (!file_exists($filePath)) {
                    // Support for the .stub file extension
                    $filePath .= '.stub';
                }

                $this->publishes(
                    [$filePath => $this->generateMigrationName($migrationFileName, $now->addSecond())],
                    "{$this->package->shortName()}-migrations"
                );

                if ($this->package->runsMigrations) {
                    $this->loadMigrationsFrom($filePath);
                }
            }

            // Publishing the Translation files.
            if ($this->package->hasTranslations) {
                $this->publishes(
                    [$this->package->basePath('/lang') => $langPath],
                    "{$this->package->shortName()}-translations"
                );
            }

            // Publishing the Asset files.
            if ($this->package->hasAssets) {
                $this->publishes(
                    [$this->package->basePath('/resources/dist') => public_path("vendor/{$this->package->shortName()}")],
                    "{$this->package->shortName()}-assets"
                );
            }
        }

        // Register the package's custom Artisan commands.
        if (!empty($this->package->commands)) {
            $this->commands($this->package->commands);
        }

        // Register the package's custom Console Artisan commands.
        if (!empty($this->package->consoleCommands) && $this->app->runningInConsole()) {
            $this->commands($this->package->consoleCommands);
        }

        // Check Boot is Enabled?
        if (!$this->bootIsEnabled()) {
            return;
        }

        // Register a translation(JSON) file namespace.
        if ($this->package->hasTranslations) {
            $this->loadTranslationsFrom($this->package->basePath('/lang/'), $this->package->shortName());
            $this->loadJsonTranslationsFrom($this->package->basePath('/lang/'));
            $this->loadJsonTranslationsFrom($langPath);
        }

        // Register a view file namespace.
        if ($this->package->hasViews) {
            $this->loadViewsFrom($this->package->basePath('/resources/views'), $this->package->viewNamespace());
        }

        // Register the given view components with a custom prefix.
        foreach ($this->package->viewComponents as $componentClass => $prefix) {
            $this->loadViewComponentsAs($prefix, [$componentClass]);
        }

        // Publishing the Component files.
        if (count($this->package->viewComponents)) {
            $this->publishes(
                [$this->package->basePath('/src/Components') => base_path("app/View/Components/vendor/{$this->package->shortName()}")],
                "{$this->package->name}-components"
            );
        }

        // Publishing the Provider stub files.
        if ($this->package->publishableProviderName) {
            $this->publishes(
                [$this->package->basePath("/resources/stubs/{$this->package->publishableProviderName}.php.stub") => base_path("app/Providers/{$this->package->publishableProviderName}.php")],
                "{$this->package->shortName()}-provider"
            );
        }

        // Load the given routes file if routes are not already cached.
        foreach ($this->package->routeFileNames as $routeFileName) {
            $this->loadRoutesFrom("{$this->package->basePath('/routes/')}{$routeFileName}.php");
        }

        // Add a piece of shared data to the environment.
        foreach ($this->package->sharedViewData as $name => $value) {
            View::share($name, $value);
        }

        // Register a view composer event.
        foreach ($this->package->viewComposers as $viewName => $viewComposer) {
            View::composer($viewName, $viewComposer);
        }

        // Package Booted.
        $this->packageBooted();
    }

    /**
     * Run when registering the Package.
     *
     * @return void
     */
    public function registeringPackage(): void {}

    /**
     * Run when the Package has been registered.
     *
     * @return void
     */
    public function packageRegistered(): void {}

    /**
     * Run when booting the Package.
     *
     * @return void
     */
    public function bootingPackage(): void {}

    /**
     * Check to allow boot Package?
     *
     * @return bool
     */
    protected function bootIsEnabled(): bool
    {
        return true;
    }

    /**
     * Run when the Package has been booted.
     *
     * @return void
     */
    public function packageBooted(): void {}

    /**
     * Get Package base directory.
     *
     * @return string
     */
    protected function getPackageBaseDir(): string
    {
        $reflector = new ReflectionClass(get_class($this));

        return dirname($reflector->getFileName(), 2);
    }

    /**
     * Package view.
     *
     * @param string|null $namespace
     * @return string|null
     */
    public function packageView(?string $namespace): ?string
    {
        return is_null($namespace) ? $this->package->shortName() : $this->package->viewNamespace;
    }
}
