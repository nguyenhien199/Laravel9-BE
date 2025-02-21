<?php

use App\Constants\ModelConst;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(TABLE_PASSWORD_HISTORY, function (Blueprint $table) {
            $table->id(ModelConst::ID_PRIMARY);

            $table->morphs('model', TABLE_PASSWORD_HISTORY.'_model_index');
            $table->string('password', 100)->nullable(false);

            $table->timestamp(ModelConst::CREATED_AT)->nullable()->useCurrent()
                ->comment('Creation time');
            $table->timestamp(ModelConst::UPDATED_AT)->nullable()->useCurrent()->useCurrentOnUpdate()
                ->comment('Last update time');

            $table->comment('Password change histories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(TABLE_PASSWORD_HISTORY);
    }
};
