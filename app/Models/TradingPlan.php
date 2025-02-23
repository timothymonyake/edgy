<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TradingPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'markets', 'timeframes', 'strategies',
        'max_risk_per_trade', 'max_weekly_drawdown', 'psychology_rules', 'performance_tracking'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function trades(): HasMany
    {
        return $this->hasMany(Trade::class);
    }
}
