<?php
// database/migrations/2026_04_07_132943_add_response_to_consultations.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            if (!Schema::hasColumn('consultations', 'response')) {
                $table->text('response')->nullable()->after('status');
            }
            
            if (!Schema::hasColumn('consultations', 'responded_at')) {
                $table->timestamp('responded_at')->nullable()->after('response');
            }
            
            if (!Schema::hasColumn('consultations', 'type')) {
                $table->enum('type', ['chat', 'video', 'phone', 'in_person'])->default('chat')->after('description');
            }
        });
    }

    public function down(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            $columns = ['response', 'responded_at', 'type'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('consultations', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};