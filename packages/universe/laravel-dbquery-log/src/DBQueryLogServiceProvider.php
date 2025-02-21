<?php

namespace Universe\DBQueryLog;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\Events\TransactionBeginning;
use Illuminate\Database\Events\TransactionCommitted;
use Illuminate\Database\Events\TransactionRolledBack;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Universe\PackageTools\Package;
use Universe\PackageTools\PackageServiceProvider;

/**
 * Class DBQueryLogServiceProvider
 *
 * @package Universe\DBQueryLog
 */
class DBQueryLogServiceProvider extends PackageServiceProvider
{
    /**
     * Configure Package.
     *
     * @param Package $package Package instance.
     * @return void
     */
    public function configurePackage(Package $package): void
    {
        $package
            ->name('dbquery-log')
            ->hasConfigFile();
    }

    /**
     * Run when the Package has been registered.
     *
     * @return void
     */
    public function packageRegistered(): void
    {
        if ((bool)$this->app['config']->get("{$this->package->shortName()}.enabled", true) === false) {
            return;
        }

        /** @var Request $request */
        $request = request();

        /** @var array $tableExcepts */
        $tableExcepts = $this->app['config']->get("{$this->package->shortName()}.table_excepts", []);

        DB::listen(function (QueryExecuted $query) use ($request, $tableExcepts) {
            $sql = $query->sql;

            // Except Tables log.
            if (is_array($tableExcepts) && !empty($sql)) {
                foreach ($tableExcepts as $tableExcept) {
                    if (str_contains($sql, "`{$tableExcept}`")) {
                        return;
                    }
                }
            }

            foreach ($query->bindings as $binding) {
                if (is_string($binding)) {
                    $binding = "'{$binding}'";
                }
                elseif (is_null($binding)) {
                    $binding = 'NULL';
                }
                elseif ($binding instanceof \Carbon\Carbon) {
                    $binding = "'{$binding->toDateTimeString()}'";
                }
                elseif ($binding instanceof \DateTime) {
                    $binding = "'{$binding->format('Y-m-d H:i:s')}'";
                }

                $sql = preg_replace("/\?/", $binding, $sql, 1);
            }

            $requestUri = $request->getPathInfo();
            Log::debug("DB-QUERY [{$query->connectionName}:{$requestUri}]", ['time' => "$query->time ms", 'sql' => $sql]);
        });

        Event::listen(TransactionBeginning::class, function (TransactionBeginning $event) {
            //Log::debug("DB-QUERY [{$event->connectionName}:START_TRANSACTION]");
        });

        Event::listen(TransactionCommitted::class, function (TransactionCommitted $event) {
            //Log::debug("DB-QUERY [{$event->connectionName}:COMMIT_TRANSACTION]");
        });

        Event::listen(TransactionRolledBack::class, function (TransactionRolledBack $event) {
            //Log::debug("DB-QUERY [{$event->connectionName}:ROLLBACK_TRANSACTION]");
        });
    }

}
