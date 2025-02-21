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
        Schema::create(TABLE_FAILED_JOB, function (Blueprint $table) {
            $table->id(ModelConst::ID_PRIMARY);

            $table->string('uuid')
                ->unique(TABLE_FAILED_JOB.'_uuid_unique');
            $table->text('connection')
                ->comment('Connection name');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent()
                ->comment('Job failed at');

            $table->timestamp(ModelConst::CREATED_AT)->nullable()->useCurrent()
                ->comment('Creation time');
            $table->timestamp(ModelConst::UPDATED_AT)->nullable()->useCurrent()->useCurrentOnUpdate()
                ->comment('Last update time');

            $table->comment('System Job failure history');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(TABLE_FAILED_JOB);
    }
};
