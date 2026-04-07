<?php
// database/migrations/2026_04_07_090306_fix_messages_table_structure.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // Rename body to content if body exists
            if (Schema::hasColumn('messages', 'body') && !Schema::hasColumn('messages', 'content')) {
                $table->renameColumn('body', 'content');
            }
            
            // Add is_read column if missing
            if (!Schema::hasColumn('messages', 'is_read')) {
                $table->boolean('is_read')->default(false)->after('content');
            }
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            if (Schema::hasColumn('messages', 'content') && !Schema::hasColumn('messages', 'body')) {
                $table->renameColumn('content', 'body');
            }
            
            if (Schema::hasColumn('messages', 'is_read')) {
                $table->dropColumn('is_read');
            }
        });
    }
};