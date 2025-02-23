<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class TradeEntryChecklist extends Model
{
    use HasFactory;

    protected $fillable = ['trade_id', 'entry_checklist_id', 'checked'];

    public function trade(): BelongsTo
    {
        return $this->belongsTo(Trade::class);
    }

    public function checklist(): BelongsTo
    {
        return $this->belongsTo(EntryChecklist::class);
    }
}
