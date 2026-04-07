<?php
// database/migrations/2026_04_07_000003_fix_advice_requests_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('advice_requests', function (Blueprint $table) {
            // Rename agrovet_id to assigned_agrovet_id if needed
            if (Schema::hasColumn('advice_requests', 'agrovet_id') && !Schema::hasColumn('advice_requests', 'assigned_agrovet_id')) {
                $table->renameColumn('agrovet_id', 'assigned_agrovet_id');
            }
            
            // Add missing columns
            if (!Schema::hasColumn('advice_requests', 'subject')) {
                $table->string('subject')->after('farmer_id');
            }
            
            if (!Schema::hasColumn('advice_requests', 'message')) {
                $table->text('message')->after('subject');
            }
            
            if (!Schema::hasColumn('advice_requests', 'response')) {
                $table->text('response')->nullable()->after('message');
            }
            
            if (!Schema::hasColumn('advice_requests', 'status')) {
                $table->enum('status', ['pending', 'assigned', 'answered', 'resolved'])->default('pending')->after('response');
            }
            
            if (!Schema::hasColumn('advice_requests', 'responded_at')) {
                $table->timestamp('responded_at')->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('advice_requests', function (Blueprint $table) {
            $columns = ['subject', 'message', 'response', 'status', 'responded_at'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('advice_requests', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};