<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submission_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained();
            $table->string('file_path');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submission_photos');
    }
};
