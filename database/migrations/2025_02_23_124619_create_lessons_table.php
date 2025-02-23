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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('trade_id')->nullable()->constrained()->onDelete('cascade'); // If related to a specific trade
            $table->string('title'); // Lesson title
            $table->text('description'); // Explanation of the lesson
            $table->enum('priority', ['Low', 'Medium', 'High'])->default('Medium'); // Prioritization
            $table->string('notion_link')->nullable(); // If linked to a Notion journal
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
