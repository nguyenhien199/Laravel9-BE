<?php

namespace Database\Seeders\Core\Traits;

use Illuminate\Support\Facades\DB;

/**
 * Trait TruncateTable
 *
 * @package Database\Seeders\Core\Traits
 */
trait TruncateTable
{
    /**
     * Truncate Table by TableName
     *
     * @param string $table Table name
     * @return bool
     */
    protected function truncate(string $table): bool
    {
        $driverName = DB::getDriverName();
        $driverName = strtolower($driverName);
        if (!$driverName || !$table) {
            return false;
        }
        switch (strtolower($driverName)) {
            case 'mysql':
                DB::table($table)->truncate();
                return true;
            case 'pgsql':
                return DB::statement("TRUNCATE TABLE {$table} RESTART IDENTITY CASCADE");
            case 'sqlite':
            case 'sqlsrv':
                return DB::statement("DELETE FROM {$table}");
            default:
                return false;
        }
    }

    /**
     * Truncate Table by list TableName
     *
     * @param array $tables list Table Name
     */
    protected function truncateMultiple(array $tables): void
    {
        foreach ($tables as $table) {
            $this->truncate($table);
        }
    }
}
