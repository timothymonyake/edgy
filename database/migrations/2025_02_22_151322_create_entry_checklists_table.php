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
        Schema::create('entry_checklists', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // e.g., "Check for major news events"
            $table->boolean('is_mandatory')->default(true); // Some rules can be optional
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entry_checklists');
    }
};
