<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('advice_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farmer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('agrovet_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('subject');
            $table->text('message');
            $table->text('response')->nullable();
            $table->enum('status', ['open', 'answered', 'closed'])->default('open');
            $table->timestamps();
        });

        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farmer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('agrovet_id')->constrained('users')->cascadeOnDelete();
            $table->string('topic');
            $table->text('description')->nullable();
            $table->dateTime('scheduled_at')->nullable();
            $table->enum('status', ['requested', 'confirmed', 'completed', 'cancelled'])->default('requested');
            $table->timestamps();
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('receiver_id')->constrained('users')->cascadeOnDelete();
            $table->text('body');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
        Schema::dropIfExists('consultations');
        Schema::dropIfExists('advice_requests');
    }
};
