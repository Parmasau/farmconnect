<?php
// database/migrations/2024_01_01_000011_add_missing_columns_to_products_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Add farmer_id if missing
            if (!Schema::hasColumn('products', 'farmer_id')) {
                $table->foreignId('farmer_id')->after('id')->constrained('users')->onDelete('cascade');
            }
            
            // Add other missing columns if needed
            if (!Schema::hasColumn('products', 'unit')) {
                $table->string('unit')->default('kg')->after('quantity');
            }
            
            if (!Schema::hasColumn('products', 'product_type')) {
                $table->enum('product_type', ['sell', 'buy'])->default('sell')->after('category');
            }
            
            if (!Schema::hasColumn('products', 'in_stock')) {
                $table->boolean('in_stock')->default(true)->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $columns = ['farmer_id', 'unit', 'product_type', 'in_stock'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('products', $column)) {
                    if ($column === 'farmer_id') {
                        $table->dropForeign(['farmer_id']);
                    }
                    $table->dropColumn($column);
                }
            }
        });
    }
};