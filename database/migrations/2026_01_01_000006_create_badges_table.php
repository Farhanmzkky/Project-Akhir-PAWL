<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description');
            $table->string('icon');
            $table->string('criteria_key');
            $table->unsignedInteger('criteria_value');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('badges');
    }
};
