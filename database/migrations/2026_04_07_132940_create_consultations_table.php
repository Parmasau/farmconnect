<?php
// database/migrations/2026_04_07_000004_create_consultations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farmer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('agrovet_id')->constrained('users')->onDelete('cascade');
            $table->string('topic');
            $table->text('description');
            $table->enum('type', ['chat', 'video', 'phone', 'in_person'])->default('chat');
            $table->enum('status', ['pending', 'accepted', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->text('response')->nullable();
            $table->datetime('scheduled_at')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();
            
            $table->index(['farmer_id', 'status']);
            $table->index(['agrovet_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};