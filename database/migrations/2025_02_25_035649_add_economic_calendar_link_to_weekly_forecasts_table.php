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
        Schema::table('weekly_forecasts', function (Blueprint $table) {
            $table->string('economic_calendar_link')->after('notion_link');
        });
    }

    public function down(): void
    {
        Schema::table('weekly_forecasts', function (Blueprint $table) {
            $table->dropColumn('economic_calendar_link');
        });
    }
};
