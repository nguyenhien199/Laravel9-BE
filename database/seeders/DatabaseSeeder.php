<?php

namespace Database\Seeders;

use Database\Seeders\Core\Traits\TruncateTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder
 *
 * @package Database\Seeders
 */
class DatabaseSeeder extends Seeder
{
    use TruncateTable;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        Model::unguard();
        $this->call([
            System\Boot::class,
            Auth\Boot::class,
        ]);
        Model::reguard();
    }
}
