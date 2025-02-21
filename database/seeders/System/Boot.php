<?php

namespace Database\Seeders\System;

use Database\Seeders\Core\Traits\DisableForeignKeys;
use Database\Seeders\Core\Traits\TruncateTable;
use Illuminate\Database\Seeder;

/**
 * Class Boot
 *
 * @package Database\Seeders\System
 */
class Boot extends Seeder
{
    use DisableForeignKeys,
        TruncateTable;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->disableForeignKeys();
        if (!app()->isProduction()) {
            $this->truncateMultiple([
                TABLE_FAILED_JOB,
                TABLE_JOB_BATCH,
                TABLE_JOB,
                TABLE_SESSION,
                TABLE_ACTIVITY_LOG,
            ]);
        }
        //$this->call([
        //    // Call Other Seeders
        //]);
        $this->enableForeignKeys();
    }
}
