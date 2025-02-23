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
        Schema::create('trading_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('markets')->nullable(); // E.g., Forex, Stocks, Crypto
            $table->text('timeframes')->nullable(); // 1H, 4H, Daily
            $table->text('strategies')->nullable(); // Breakout, Killzone, etc.
            $table->decimal('max_risk_per_trade', 5, 2)->nullable(); // E.g., 1% per trade
            $table->decimal('max_weekly_drawdown', 5, 2)->nullable(); // E.g., 5%
            $table->text('psychology_rules')->nullable(); // No revenge trading, etc.
            $table->text('performance_tracking')->nullable(); // How they review performance
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trading_plans');
    }
};
