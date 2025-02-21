<?php

use App\Constants\ModelConst;
use App\Enums\GenderFlag;
use App\Enums\StatusFlag;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(TABLE_USER, function (Blueprint $table) {
            $table->id(ModelConst::ID_PRIMARY);

            $table->unsignedTinyInteger('status')->nullable(false)->default(StatusFlag::ACTIVE)
                ->comment('1: active(display), 0: inactive(not display).(default: 1)');
            $table->string('username', 100)->nullable(false)
                ->comment('User username to login (unique)')
                ->unique(TABLE_USER.'_username_unique');
            $table->string('password', 100)->nullable(false)
                ->comment('User password to login');

            $table->string('firstname', 100)->nullable(false)
                ->comment('User firstname');
            $table->string('lastname', 100)->nullable(false)
                ->comment('User lastname');
            $table->unsignedTinyInteger('gender')->nullable(false)->default(GenderFlag::OTHER)
                ->comment('User Gender 0: OTHER, 1: MALE, 2: FEMALE. (default: 0)');
            $table->date('birthday')->nullable()->default(null)
                ->comment('User birthday')
                ->index(TABLE_USER.'_birthday_index');

            $table->string('phone', 20)->nullable(false)
                ->comment('user phone number to login by OTP code (unique)')
                ->unique(TABLE_USER.'_phone_unique');
            $table->timestamp('phone_verified_at')->nullable()->default(null)
                ->comment('User phone verified at');
            $table->string('email', 100)->nullable(false)
                ->comment('User email to login by SSO (unique)')
                ->unique(TABLE_USER.'_email_unique');
            $table->timestamp('email_verified_at')->nullable()->default(null)
                ->comment('User email verified at');

            $table->string('avatar')->nullable()->default(null)
                ->comment('User avatar url');
            $table->string('description')->nullable()->default(null)
                ->comment('Description for User');

            $table->string('secret', 100)->nullable()->default(null)
                ->comment('User secret');
            $table->string('remember_token', 100)->nullable()->default(null)
                ->comment('User remember token');
            $table->string('lang', 20)->nullable()->default(app_locale_original())
                ->comment('Locale code');
            $table->string('timezone', 100)->nullable()->default(app_timezone())
                ->comment('Timezone (default by system)')
                ->index(TABLE_USER.'_timezone_index');

            $table->string('organization')->nullable()->default(null)
                ->comment('Organization/Company name');
            $table->string('department')->nullable()->default(null)
                ->comment('Department name');
            $table->string('position')->nullable()->default(null)
                ->comment('Job position');
            $table->string('address')->nullable()->default(null)
                ->comment('Address');
            $table->string('city')->nullable()->default(null)
                ->comment('City name');
            $table->string('country')->nullable()->default(null)
                ->comment('Country name');

            $table->timestamp('password_changed_at')->nullable()->default(null)
                ->comment('Last password change at');
            $table->timestamp('first_login_at')->nullable()->default(null)
                ->comment('First login at');
            $table->string('first_login_ip', 45)->nullable()->default(null)
                ->comment('First login ip');
            $table->timestamp('last_login_at')->nullable()->default(null)
                ->comment('Last login at');
            $table->string('last_login_ip', 45)->nullable()->default(null)
                ->comment('Last login ip');

            $table->timestamp(ModelConst::CREATED_AT)->nullable()->useCurrent()
                ->comment('Creation time');
            $table->timestamp(ModelConst::UPDATED_AT)->nullable()->useCurrent()->useCurrentOnUpdate()
                ->comment('Last update time');
            $table->softDeletes(ModelConst::DELETED_AT)->nullable()->default(null)
                ->comment('Soft delete time');

            $table->comment('Users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(TABLE_USER);
    }
};
