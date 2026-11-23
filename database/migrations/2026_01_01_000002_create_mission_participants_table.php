<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mission_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('mission_id')->constrained();
            $table->string('status')->default('in_progress');
            $table->unsignedInteger('reward_xp_snapshot');
            $table->string('category_snapshot');
            $table->timestamp('joined_at');
            $table->timestamp('completed_at')->nullable();
            $table->unique(['user_id', 'mission_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mission_participants');
    }
};
