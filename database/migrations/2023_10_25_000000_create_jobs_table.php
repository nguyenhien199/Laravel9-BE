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
        Schema::create(TABLE_JOB, function (Blueprint $table) {
            $table->id(ModelConst::ID_PRIMARY);

            $table->string('queue')
                ->index(TABLE_JOB.'_queue_index');
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts')
                ->index(TABLE_JOB.'_attempts_index');

            $table->unsignedInteger('reserved_at')->nullable()->default(null);
            $table->unsignedInteger('available_at')->nullable()->default(null);
            $table->unsignedInteger('created_at')->nullable()->default(null);

            $table->comment('System Jobs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(TABLE_JOB);
    }
};
