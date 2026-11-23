<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('missions', function (Blueprint $table) {
            $table->id();
            $table->string('seed_key')->nullable()->unique();
            $table->string('title')->unique();
            $table->text('description');
            $table->string('category');
            $table->unsignedTinyInteger('required_level');
            $table->unsignedInteger('xp_reward');
            $table->text('evidence_instructions');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('missions');
    }
};
