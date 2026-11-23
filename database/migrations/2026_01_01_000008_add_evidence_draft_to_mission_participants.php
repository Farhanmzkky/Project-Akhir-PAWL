<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mission_participants', function (Blueprint $table) {
            $table->text('draft_description')->nullable();
            $table->json('draft_photos')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('mission_participants', function (Blueprint $table) {
            $table->dropColumn(['draft_description', 'draft_photos']);
        });
    }
};
