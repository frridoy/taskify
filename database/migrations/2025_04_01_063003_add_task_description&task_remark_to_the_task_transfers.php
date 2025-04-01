<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('task_transfers', function (Blueprint $table) {
            $table->string('task_description')->nullable()->after('transferred_by');
            $table->string('task_remark')->nullable()->after('task_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('task_transfers', function (Blueprint $table) {
            $table->dropColumn('task_description');
            $table->dropColumn('task_remark');
        });
    }
};
