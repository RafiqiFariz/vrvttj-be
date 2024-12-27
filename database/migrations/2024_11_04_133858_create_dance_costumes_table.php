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
        Schema::create('dance_costumes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Dance::class)->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('picture')->nullable();
            $table->string('asset_path')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dance_costumes');
    }
};
