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
        Schema::table('task_notes', function (Blueprint $table) {
            if (Schema::hasColumn('task_notes', 'task_id')) {
                $table->dropColumn('task_id');
            }

            if (!Schema::hasColumn('task_notes', 'grouped_date')) {
                $table->date('grouped_date')->after('user_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
