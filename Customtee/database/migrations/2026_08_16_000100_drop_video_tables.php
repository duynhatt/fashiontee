<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('tag_video');
        Schema::dropIfExists('videos');
        Schema::dropIfExists('video_tags');
    }

    public function down(): void
    {
        // Intentionally empty — video feature was removed.
    }
};
