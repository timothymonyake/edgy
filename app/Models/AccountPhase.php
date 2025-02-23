<?php

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccountPhase extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id', 'phase_id', 'initial_balance', 'current_balance', 'equity',
        'max_loss', 'daily_loss_limit', 'profit_target', 'status', 'started_at', 'ended_at'
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function trades(): HasMany
    {
        return $this->hasMany(Trade::class);
    }
}
