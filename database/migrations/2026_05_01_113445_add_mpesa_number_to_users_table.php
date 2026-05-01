<?php
// database/migrations/2026_05_01_000000_add_mpesa_number_to_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'mpesa_number')) {
                $table->string('mpesa_number')->nullable()->after('phone');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'mpesa_number')) {
                $table->dropColumn('mpesa_number');
            }
        });
    }
};