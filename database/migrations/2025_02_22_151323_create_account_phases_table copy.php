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
        Schema::create('account_phases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained()->onDelete('cascade');
            $table->foreignId('phase_id')->constrained()->onDelete('cascade');
            $table->decimal('initial_balance', 10, 2);
            $table->decimal('current_balance', 10, 2)->default(0);
            $table->decimal('equity', 10, 2)->default(0);
            $table->decimal('max_loss', 10, 2);
            $table->decimal('daily_loss_limit', 10, 2);
            $table->decimal('profit_target', 10, 2);
            $table->enum('status', ['active', 'passed', 'failed'])->default('Active');
            $table->timestamp('started_at')->useCurrent();
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_phases');
    }
};
