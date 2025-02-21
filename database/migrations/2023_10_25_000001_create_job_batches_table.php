<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(TABLE_JOB_BATCH, function (Blueprint $table) {
            $table->string('id')->primary();

            $table->string('name')
                ->comment('Job batch name');
            $table->integer('total_jobs')
                ->comment('Total number of Jobs');
            $table->integer('pending_jobs')
                ->comment('Total number of pending Jobs');
            $table->integer('failed_jobs')
                ->comment('Total number of failed Jobs');
            $table->longText('failed_job_ids')
                ->comment('Failed Jobs ID list');
            $table->mediumText('options')->nullable()->default(null);

            $table->integer('cancelled_at')->nullable()->default(null);
            $table->integer('created_at')->nullable()->default(null);
            $table->integer('finished_at')->nullable()->default(null);

            $table->comment('System Job Batches');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(TABLE_JOB_BATCH);
    }
};
