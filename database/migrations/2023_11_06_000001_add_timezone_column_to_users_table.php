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
        if (!Schema::hasColumn(TABLE_USER, 'timezone')) {
            Schema::table(TABLE_USER, function (Blueprint $table) {
                $table->string('timezone', 100)->nullable()->default(null)
                    ->comment('Timezone (default by system)')
                    ->index(TABLE_USER.'_timezone_index')
                    ->after('remember_token');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(TABLE_USER, function (Blueprint $table) {
            // Not execute because the default already exists when updating User information.
            //$table->dropColumn('timezone');
        });
    }
};
