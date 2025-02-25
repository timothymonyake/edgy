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
        Schema::create('weekly_forecasts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('week_start'); // Start of the forecast week
            $table->date('week_end'); // End of the forecast week
            $table->text('market_bias')->nullable(); // Bullish, Bearish, or Neutral forecast
            $table->text('key_levels')->nullable(); // Important price levels to watch
            $table->text('news_events')->nullable(); // Major news impacting the market
            $table->text('trade_ideas')->nullable(); // Planned trades for the week
            $table->string('notion_link')->nullable(); // Link to forecast journal on Notion
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_forecasts');
    }
};
