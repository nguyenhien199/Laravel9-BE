<?php

use App\Constants\ModelConst;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection(config('activitylog.database_connection'))
            ->create(config('activitylog.table_name'), function (Blueprint $table) {
                $table->id(ModelConst::ID_PRIMARY);

                $table->string('log_name', 100)->nullable()->default('default')
                    ->comment('Log Activity name')
                    ->index(config('activitylog.table_name').'_log_name_index');
                $table->text('description')->nullable()->default(null)
                    ->comment('Description of the Activity');
                $table->nullableMorphs('subject', config('activitylog.table_name').'_subject_index');
                $table->nullableMorphs('causer', config('activitylog.table_name').'_causer_index');
                $table->string('event')->nullable()->default(null)
                    ->comment('Event of the Activity');
                $table->json('properties')->nullable()->default(null)
                    ->comment('Properties of the Activity');
                $table->uuid('batch_uuid')->nullable()->default(null)
                    ->comment('Batch UUID of the  Activity');

                $table->timestamp(ModelConst::CREATED_AT)->nullable()->useCurrent()
                    ->comment('Creation time');
                $table->timestamp(ModelConst::UPDATED_AT)->nullable()->useCurrent()->useCurrentOnUpdate()
                    ->comment('Last update time');

                $table->comment('System Activity logs');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection(config('activitylog.database_connection'))
            ->dropIfExists(config('activitylog.table_name'));
    }
};
