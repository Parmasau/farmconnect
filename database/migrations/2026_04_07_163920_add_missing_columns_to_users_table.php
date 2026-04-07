<?php
// database/migrations/2026_04_07_000017_add_missing_columns_to_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add business_name column for agrovets and admins
            if (!Schema::hasColumn('users', 'business_name')) {
                $table->string('business_name')->nullable()->after('name');
            }
            
            // Add bio column
            if (!Schema::hasColumn('users', 'bio')) {
                $table->text('bio')->nullable()->after('email');
            }
            
            // Add address column
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('bio');
            }
            
            // Add phone column if missing
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            
            // Add profile_photo column if missing
            if (!Schema::hasColumn('users', 'profile_photo')) {
                $table->string('profile_photo')->nullable()->after('address');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = ['business_name', 'bio', 'address', 'phone', 'profile_photo'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};