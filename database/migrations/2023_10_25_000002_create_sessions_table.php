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
        Schema::create(TABLE_SESSION, function (Blueprint $table) {
            $table->string('id')->primary();

            $table->foreignId('user_id')->nullable()->default(null)
                ->index(TABLE_SESSION.'_user_id_index');
            $table->string('ip_address', 45)->nullable()->default(null);
            $table->text('user_agent')->nullable()->default(null);
            $table->longText('payload');
            $table->integer('last_activity')
                ->index(TABLE_SESSION.'_last_activity_index');

            $table->timestamp(ModelConst::CREATED_AT)->nullable()->useCurrent()
                ->comment('Creation time');
            $table->timestamp(ModelConst::UPDATED_AT)->nullable()->useCurrent()->useCurrentOnUpdate()
                ->comment('Last update time');

            $table->comment('System Sessions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(TABLE_SESSION);
    }
};
