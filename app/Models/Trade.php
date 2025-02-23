<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trade extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id', 'account_phase_id', 'pair_id', 'kill_zone_id', 'plan_id',
        'lot_size', 'entry_price', 'exit_price', 'profit_loss', 'is_weekly_plan_followed',
        'is_checklist_followed', 'status', 'annulment_reason', 'annulment_screenshot', 'journal_link'
    ];

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function phase(): BelongsTo
    {
        return $this->belongsTo(AccountPhase::class, 'account_phase_id');
    }

    public function pair(): BelongsTo
    {
        return $this->belongsTo(Pair::class);
    }

    public function killZone(): BelongsTo
    {
        return $this->belongsTo(KillZone::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(TradingPlan::class);
    }

    public function checklists(): HasMany
    {
        return $this->hasMany(TradeEntryChecklist::class);
    }
}
