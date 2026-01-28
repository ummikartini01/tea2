<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tea_timetables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('schedule'); // JSON array of tea schedule entries
            $table->boolean('is_active')->default(true);
            $table->boolean('telegram_notifications_enabled')->default(false);
            $table->string('telegram_chat_id')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('timezone')->default('UTC');
            $table->timestamps();
            
            $table->index(['user_id', 'is_active']);
            $table->index(['telegram_notifications_enabled', 'telegram_chat_id'], 'telegram_notifications_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tea_timetables');
    }
};
