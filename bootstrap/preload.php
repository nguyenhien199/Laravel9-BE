<?php

/**
 * [OPCache] Preload is as dangerous as a NUCLEAR BOMB, so it's important to know exactly what to do.
 *
 * @author ThuyVu <thuyvv.hn@gmail.com>
 */

error_reporting(0);

global $BASE_PATH;
$BASE_PATH = realpath(__DIR__.'/..');

$autoload = $BASE_PATH.'/vendor/autoload.php';
if (!file_exists($autoload) || !is_readable($autoload) || !@include_once($autoload)) {
    return;
}
require_once($autoload);

/**
 * Class Preloader for OPCache
 *
 * @author ThuyVu <thuyvv.hn@gmail.com>
 */
class Preloader
{
    /** @var array List of classes to ignore. */
    private $ignoreClasses = [];

    /** @var int Total count of classes preloaded. */
    private static $count = 0;

    /** @var string[] List of paths to load. */
    private $paths = [];

    /** @var string[] List of Classmap in Vendor autoload. */
    private $fileMaps = [];

    /**
     * Constructor.
     *
     * @param string ...$paths
     */
    public function __construct(...$paths)
    {
        global $BASE_PATH;

        $this->paths = $paths;

        $autoloadClassmap = $BASE_PATH.'/vendor/composer/autoload_classmap.php';
        if (file_exists($autoloadClassmap) && is_readable($autoloadClassmap)) {
            // We'll use composer's classmap to easily find which classes to autoload, based on their filename.
            try {
                $classMaps = require_once($autoloadClassmap);

                $this->fileMaps = array_flip($classMaps);
            }
            catch (\Throwable $e) {
                // Do nothing
            }
        }
    }

    /**
     * Merge Path list.
     *
     * @param string ...$paths
     * @return $this
     */
    public function paths(...$paths)
    {
        $this->paths = array_merge($this->paths, $paths);

        return $this;
    }

    /**
     * Merge Class list to ignore.
     *
     * @param string ...$names
     * @return $this
     */
    public function ignoreClass(...$names)
    {
        $this->ignoreClasses = array_merge($this->ignoreClasses, $names);

        return $this;
    }

    /**
     * Loads all registered paths.
     *
     * @return void
     */
    public function load()
    {
        if (!extension_loaded('Zend OPcache')) {
            echo 'The Zend OPcache extension does not appear to be installed!';
            return;
        }

        $ocEnabled = ini_get('opcache.enable');
        if (empty($ocEnabled)) {
            echo 'The Zend OPcache extension is installed but not active!';
            return;
        }

        if (empty($this->fileMaps)) {
            echo 'The FileMaps is empty!';
            return;
        }

        // We'll loop over all registered paths and load them one by one.
        foreach ($this->paths as $path) {
            $this->loadPath(rtrim($path, '/'));
        }

        $count = self::$count;

        echo "[Preloader] Preloaded {$count} classes".PHP_EOL;
    }

    /**
     * Loads a single path.
     *
     * @param string $path
     * @return void
     */
    private function loadPath($path)
    {
        // If the current path is a directory, we'll load all files in it.
        if (is_dir($path)) {
            $this->loadDir($path);

            return;
        }

        // Otherwise we'll just load this one file.
        $this->loadFile($path);
    }

    /**
     * Loads list directory of a path.
     *
     * @param string $path
     * @return void
     */
    private function loadDir($path)
    {
        $handle = opendir($path);

        // We'll loop over all files and directories in the current path, and load them one by one.
        while ($file = readdir($handle)) {
            if (in_array($file, ['.', '..'])) {
                continue;
            }

            $this->loadPath("{$path}/{$file}");
        }

        closedir($handle);
    }

    /**
     * Load file.
     *
     * @param string $file
     * @return void
     */
    private function loadFile($file)
    {
        if (empty($file) || in_array($file, ['.', '..']) || !preg_match("/\.php$/i", $file)) {
            return;
        }

        // We resolve the classname from composer autoload mapping.
        $class = !empty($this->fileMaps[$file]) ? $this->fileMaps[$file] : null;

        // And use it to make sure the class shouldn't be ignored.
        if ($this->shouldIgnoreClass($class)) {
            return;
        }

        // Finally we require the path, causing all its dependencies to be loaded as well.
        try {
            if (!file_exists($file)) {
                echo "Class `{$class}` does not exist!".PHP_EOL;
                return;
            }
            elseif (!\is_readable($file)) {
                echo "Class `{$class}` is unreadable!".PHP_EOL;
                return;
            }
            // @ - to suppress warnings
            elseif (!@include_once($file)) {
                echo "Class `{$class}` has a problem!".PHP_EOL;
                return;
            }
            else {
                require_once($file);

                self::$count++;
                #echo "[Preloader] Preloaded `{$class}`".PHP_EOL;
            }
        }
        catch (\Throwable $e) {
            return;
        }
    }

    /**
     * Checks if the Class should be ignored.
     *
     * @param string|null $name
     * @return bool
     */
    private function shouldIgnoreClass($name = null)
    {
        if (empty($name)) {
            return true;
        }

        foreach ($this->ignoreClasses as $ignore) {
            if (strpos($name, $ignore) === 0) {
                return true;
            }
        }

        return false;
    }
}

(new Preloader())
    ->paths($BASE_PATH.'/vendor/laravel/framework')
    ->ignoreClass(
        \Illuminate\Filesystem\Cache::class,
        \Illuminate\Log\LogManager::class,
        \Illuminate\Http\Testing\File::class,
        \Illuminate\Http\UploadedFile::class,
        \Illuminate\Support\Carbon::class
    )
    ->load();
