<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Check if column doesn't exist before adding
            if (!Schema::hasColumn('products', 'farmer_id')) {
                $table->foreignId('farmer_id')->after('id')->nullable()->constrained('users')->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'farmer_id')) {
                $table->dropForeign(['farmer_id']);
                $table->dropColumn('farmer_id');
            }
        });
    }
};