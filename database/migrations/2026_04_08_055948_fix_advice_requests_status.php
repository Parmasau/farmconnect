<?php
// database/migrations/2026_04_08_000001_fix_advice_requests_status.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('advice_requests', function (Blueprint $table) {
            // Update status enum to include all possible values
            $table->enum('status', ['pending', 'assigned', 'answered', 'resolved'])->default('pending')->change();
        });
    }

    public function down(): void
    {
        Schema::table('advice_requests', function (Blueprint $table) {
            $table->enum('status', ['pending', 'answered', 'resolved'])->default('pending')->change();
        });
    }
};