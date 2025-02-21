<?php

namespace Database\Seeders\Auth;

use App\Enums\GenderFlag;
use App\Enums\StatusFlag;
use App\Models\User;
use Database\Seeders\Core\Traits\DisableForeignKeys;
use Database\Seeders\Core\Traits\TruncateTable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Class UserSeeder
 *
 * @package Database\Seeders\Auth
 */
class UserSeeder extends Seeder
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
        if ((app()->isProduction() && User::query()->count() <= 1) || !app()->isProduction()) {
            $this->truncate(TABLE_USER);
            // Create Admin-User
            User::query()->create(static::genAdminUserAttr());
        }

        if (!app()->isProduction()) {
            #$unguarded = User::isUnguarded();
            #User::unguard(false);

            // Create Test-User
            User::query()->create(static::genTestUserAttr());

            // Create Random User
            User::factory()
                ->count(5)
                ->create();
            #User::unguard($unguarded);
        }
        $this->enableForeignKeys();
    }

    /**
     * Gen Admin user attributes.
     *
     * @return array
     */
    private function genAdminUserAttr(): array
    {
        return [
            'id'                => 1,
            'status'            => StatusFlag::ACTIVE,
            'username'          => 'admin@example.com',
            'password'          => 'password',
            'firstname'         => 'Admin',
            'lastname'          => 'User',
            'gender'            => GenderFlag::OTHER,
            'birthday'          => '1988-07-23',
            'phone'             => '0987654321',
            'phone_verified_at' => now(),
            'email'             => 'admin@example.com',
            'email_verified_at' => now(),
            'avatar'            => null,
            'description'       => 'Super Administrator',
            'secret'            => Str::random(10),
            'remember_token'    => Str::random(10),
            'lang'              => app_locale_original(),
            'timezone'          => app_timezone(),
            'organization'      => null,
            'department'        => null,
            'position'          => null,
            'address'           => null,
            'city'              => null,
            'country'           => null,
        ];
    }

    /**
     * Gen Test user attributes.
     *
     * @return array
     */
    private function genTestUserAttr(): array
    {
        return [
            'id'                => 2,
            'status'            => StatusFlag::ACTIVE,
            'username'          => 'user@example.com',
            'password'          => 'password',
            'firstname'         => 'User',
            'lastname'          => 'User',
            'gender'            => GenderFlag::OTHER,
            'birthday'          => '1988-07-23',
            'phone'             => '0987654322',
            'phone_verified_at' => now(),
            'email'             => 'user@example.com',
            'email_verified_at' => now(),
            'avatar'            => null,
            'description'       => 'User demo',
            'secret'            => Str::random(10),
            'remember_token'    => Str::random(10),
            'lang'              => app_locale_original(),
            'timezone'          => app_timezone(),
            'organization'      => null,
            'department'        => null,
            'position'          => null,
            'address'           => null,
            'city'              => null,
            'country'           => null,
        ];
    }
}
