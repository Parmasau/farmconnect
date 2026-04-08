<?php
// database/migrations/2026_04_08_000002_add_missing_columns_to_advice_requests.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('advice_requests', function (Blueprint $table) {
            // Add assigned_agrovet_id if missing
            if (!Schema::hasColumn('advice_requests', 'assigned_agrovet_id')) {
                $table->foreignId('assigned_agrovet_id')->nullable()->after('farmer_id')->constrained('users')->onDelete('set null');
            }
            
            // Add subject if missing
            if (!Schema::hasColumn('advice_requests', 'subject')) {
                $table->string('subject')->after('assigned_agrovet_id');
            }
            
            // Add message if missing (your table might use 'content' instead)
            if (!Schema::hasColumn('advice_requests', 'message')) {
                $table->text('message')->after('subject');
            }
            
            // Add response if missing
            if (!Schema::hasColumn('advice_requests', 'response')) {
                $table->text('response')->nullable()->after('message');
            }
            
            // Add status if missing or modify it
            if (!Schema::hasColumn('advice_requests', 'status')) {
                $table->enum('status', ['pending', 'assigned', 'answered', 'resolved'])->default('pending')->after('response');
            } else {
                $table->enum('status', ['pending', 'assigned', 'answered', 'resolved'])->default('pending')->change();
            }
            
            // Add responded_at if missing
            if (!Schema::hasColumn('advice_requests', 'responded_at')) {
                $table->timestamp('responded_at')->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('advice_requests', function (Blueprint $table) {
            $columns = ['assigned_agrovet_id', 'subject', 'message', 'response', 'status', 'responded_at'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('advice_requests', $column)) {
                    if ($column === 'assigned_agrovet_id') {
                        $table->dropForeign(['assigned_agrovet_id']);
                    }
                    $table->dropColumn($column);
                }
            }
        });
    }
};