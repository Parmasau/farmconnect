<?php
// database/migrations/2026_04_07_090308_add_missing_columns_to_products_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Add category column if missing
            if (!Schema::hasColumn('products', 'category')) {
                $table->string('category')->nullable()->after('description');
            }
            
            // Add product_type column if missing
            if (!Schema::hasColumn('products', 'product_type')) {
                $table->string('product_type')->default('sell')->after('status');
            }
            
            // Add unit column if missing
            if (!Schema::hasColumn('products', 'unit')) {
                $table->string('unit')->default('kg')->after('quantity');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'category')) {
                $table->dropColumn('category');
            }
            if (Schema::hasColumn('products', 'product_type')) {
                $table->dropColumn('product_type');
            }
            if (Schema::hasColumn('products', 'unit')) {
                $table->dropColumn('unit');
            }
        });
    }
};