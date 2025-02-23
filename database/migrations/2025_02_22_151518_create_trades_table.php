<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('trades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')->constrained()->onDelete('cascade');
            $table->foreignId('account_phase_id')->constrained('account_phases')->onDelete('cascade');
            $table->foreignId('pair_id')->constrained()->onDelete('cascade');
            $table->foreignId('kill_zone_id')->constrained()->onDelete('cascade');
            $table->foreignId('trading_plan_id')->constrained()->onDelete('cascade');
            $table->decimal('lot_size', 10, 2);
            $table->decimal('entry_price', 10, 5);
            $table->decimal('exit_price', 10, 5)->nullable();
            $table->decimal('profit_loss', 10, 2);
            $table->boolean('is_weekly_plan_followed')->default(false);
            $table->boolean('is_checklist_followed')->default(false);
            $table->enum('status', ['pending', 'running', 'complete', 'annulled'])->default('complete');
            $table->text('annulment_reason')->nullable();
            $table->string('annulment_screenshot')->nullable();
            $table->string('journal_link')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trades');
    }
};
