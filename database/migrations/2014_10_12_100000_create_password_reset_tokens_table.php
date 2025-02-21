<?php

use App\Constants\ModelConst;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(TABLE_PASSWORD_RESET_TOKEN, function (Blueprint $table) {
            $table->id(ModelConst::ID_PRIMARY);

            $table->string('email')->nullable()->default(null)
                ->index(TABLE_PASSWORD_RESET_TOKEN.'_email_index');
            $table->string('phone', 20)->nullable()->default(null)
                ->index(TABLE_PASSWORD_RESET_TOKEN.'_phone_index');
            $table->string('token')->nullable()->default(null)
                ->index(TABLE_PASSWORD_RESET_TOKEN.'_token_index');

            $table->timestamp(ModelConst::CREATED_AT)->nullable()->useCurrent()
                ->comment('Creation time');
            $table->timestamp(ModelConst::UPDATED_AT)->nullable()->useCurrent()->useCurrentOnUpdate()
                ->comment('Last update time');

            $table->comment('Password reset tokens');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(TABLE_PASSWORD_RESET_TOKEN);
    }
};
