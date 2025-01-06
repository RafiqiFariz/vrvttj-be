<?php

use App\Models\DancePart;
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
        Schema::create('dance_part_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(DancePart::class)->constrained()->cascadeOnDelete();
            $table->string('thumbnail_path')->nullable();
            $table->string('video_path');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dance_part_videos');
    }
};
