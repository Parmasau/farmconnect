<?php
// database/migrations/2026_05_01_000002_add_till_number_to_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'till_number')) {
                $table->string('till_number')->nullable()->after('mpesa_number');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'till_number')) {
                $table->dropColumn('till_number');
            }
        });
    }
};