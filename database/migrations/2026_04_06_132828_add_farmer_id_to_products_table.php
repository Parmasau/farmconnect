<?php
// database/migrations/2024_01_01_000011_add_farmer_id_to_products_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Add farmer_id column
            if (!Schema::hasColumn('products', 'farmer_id')) {
                $table->foreignId('farmer_id')->after('id')->constrained('users')->onDelete('cascade');
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