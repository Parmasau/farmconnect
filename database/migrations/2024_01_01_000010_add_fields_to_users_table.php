<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'farmer', 'agrovet'])->default('farmer')->after('email');
            $table->string('phone')->nullable()->after('role');
            $table->string('location')->nullable()->after('phone');
            $table->text('bio')->nullable()->after('location');
            $table->string('avatar')->nullable()->after('bio');
            $table->boolean('is_active')->default(true)->after('avatar');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'location', 'bio', 'avatar', 'is_active']);
        });
    }
};
