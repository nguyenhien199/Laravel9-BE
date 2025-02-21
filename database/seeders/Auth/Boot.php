<?php

namespace Database\Seeders\Auth;

use Database\Seeders\Core\Traits\DisableForeignKeys;
use Database\Seeders\Core\Traits\TruncateTable;
use Illuminate\Database\Seeder;

/**
 * Class Boot
 *
 * @package Database\Seeders\Auth
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
                TABLE_PASSWORD_RESET_TOKEN,
                TABLE_PASSWORD_HISTORY,
            ]);
        }
        $this->call([
            UserSeeder::class,
        ]);
        $this->enableForeignKeys();
    }
}
